<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Data\Models\DataDelegate;
use iProtek\Data\Models\DataDelegateInputValues;

class DataDelegateController extends _CommonController
{
    //
    public function get_delegates(Request $request){
        $this->validate($request,[
            "source_id"=>"required",
            "source_name"=>"required"
        ]); 
        $source_id = $request->source_id;
        $source_name = $request->source_name;
        return DataDelegate::where('source_id', $source_id)->where( 'source_name', $source_name)->get();
    }

    public function add_delegate(Request $request){
        $this->validate($request,[
            "source_id"=>"required",
            "source_name"=>"required",
            "placeholder"=>"required",
            "field_info"=>"required",
            "source_type"=>"required",
            //"order_id"=>"required"
        ]); 
        $user = auth()->user();


        //Check if already exists
        $exists = DataDelegate::where('source_id', $request->source_id)->where('source_name', $request->source_name)->where('placeholder', $request->placeholder)->first();
        if($exists){
            return ["status"=>0, "message"=>"Placeholder/Field Title already exists"];
        }
        $count = DataDelegate::where('source_id', $request->source_id)->where('source_name', $request->source_name)->count();

        $newData = DataDelegate::create([
            "source_id" => $request->source_id,
            "source_name" => $request->source_name,
            "placeholder" => $request->placeholder,
            "field_info" => json_encode( $request->field_info ),
            "source_type" => $request->source_type,
            "created_by" => $user->id,
            "order_id" => ($count+1),
            "is_show" => $request->is_show //( $request->is_show == 1)
        ]);

        
        //DataDelegate
        return [
            "status"=>1,
            "message"=>"Successfully added.",
            "data"=>$newData
        ];
    }

    public function edit_delegate(Request $request, DataDelegate $id){
        
        $this->validate($request,[
            "id"=>"required",
            "source_id"=>"required",
            "source_name"=>"required",
            "placeholder"=>"required",
            "field_info"=>"required",
            "source_type"=>"required",
            //"order_id"=>"required"
        ]); 
        $user = auth()->user();

        //Check if already exists
        $exists = DataDelegate::whereRaw('id <> ?',[$id->id])->where('source_id', $request->source_id)->where('source_name', $request->source_name)->where('placeholder', $request->placeholder)->first();
        if($exists){
            return ["status"=>0, "message"=>"Placeholder/Title has a conflict."];
        }
        $count = DataDelegate::where('source_id', $request->source_id)->where('source_name', $request->source_name)->count();
        $id->placeholder = $request->placeholder;
        $id->field_info = json_encode( $request->field_info );
        $id->source_type = $request->source_type;
        $id->updated_by = $user->id;
        $id->is_show = $request->is_show;
        $id->save();
        
        //DataDelegate
        return [
            "status"=>1,
            "message"=>"Successfully Updated.",
            "data"=>$id
        ];
    }

    public function get_delegate_values(Request $request){
        
        $this->validate($request,[
            "source_id"=>"required",
            "source_name"=>"required",
            "key_name"=>"required"
        ]); 

        $source_id = $request->source_id;
        $source_name = $request->source_name;
        $key_name = $request->key_name;
        $delegate_id = $request->delegate_id;
        if($delegate_id)
            return \iProtek\Data\Helpers\DataDelegateHelper::get_data_delegate($source_id, $source_name, $key_name);
        else 
            return \iProtek\Data\Helpers\DataDelegateHelper::get_data_delegate($source_id, $source_name, $key_name, $delegate_id);
    }

    public function update_delegate_values(Request $request){
        
        $this->validate($request,[
            //"source_id"=>"required",
            //"source_name"=>"required",
            "key_name"=>"required"
        ]); 
        $user = auth()->user();
        $delegate_items = $request->update_delegate_values;

        foreach($delegate_items as $item){  
            $getVal = DataDelegateInputValues::where( 'data_delegate_id', $item['id'])->where('key_name', $request->key_name)->first();
            if($getVal){
                $getVal->input_value = $item['value'];
                if($getVal->isDirty()){
                    $getVal->updated_by = $user->id;
                    $getVal->save();
                }
            }
            else{
                if($item['value']){
                    DataDelegateInputValues::create([
                        "data_delegate_id"=>$item['id'],
                        "key_name"=>$request->key_name,
                        "input_value"=>$item['value'],
                        "created_by"=>$user->id
                    ]);
                }
            }

        }


        return [
            "status"=>1,
            "message"=>"Done updating."
        ];
    }

}
