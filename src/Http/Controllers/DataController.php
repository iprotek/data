<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;  
use iProtek\Data\Models\Data;
use iProtek\Data\Models\DataModel; 
use iProtek\Data\Models\ModelField;
use iProtek\Data\Models\DataModelField;
use iProtek\Data\Models\DataModelFieldValue;
use iProtek\Data\Helpers\DataFieldHelper;
use iProtek\Core\Models\UserAdminPayAccount;
use iProtek\Core\Http\Controllers\_Common\_CommonController;

class DataController extends _CommonController
{
    //

    public function contact_projects(Request $request, Data $id){
        if($id->data_model_type == 'project')
            return [];
        $results = DataModelFieldValue::where('value3', $id->id)->select('project_data_id')->groupBy('project_data_id')->get()->pluck('project_data_id')->toArray();
        
        $projects = Data::with('data_model')->where('data_model_type','project')->whereIn('id', $results)->get();
        return $projects;
    }

    public function get(Request $request, Data $id){
        
        
        $result = DataModel::with(['fields'=>function($q){
            $q->with('model_field');//->select('*', \DB::raw(" '[]' as data_values "));
        }])->find($id->data_model_id);

        $fields = $result->fields;
        
        $arranged = DataFieldHelper::fieldsgetSub($fields, 0, $id->id);
        //Arrange here
        $id->field_values = $arranged;

        return $id;

    }

    public function list(Request $request){

        $project_model_fields = Data::with(['data_model']);//BillingAccount::on(); 
        $search_text = str_replace(' ','%', $request->search?:"");
        $project_model_fields->whereRaw(" name LIKE CONCAT('%',?,'%')",[$search_text])->orderBy('name','ASC');
        if($request->data_model_id > 0){
            $project_model_fields->where('data_model_id', $request->data_model_id);
        }


        return $project_model_fields->paginate(10);

    }

    public function list_selection(Request $request){
        $fields = Data::on();//BillingAccount::on(); 
        $search_text = str_replace(' ','%', $request->search_text?:"");
        $fields->whereRaw(" name LIKE CONCAT('%',?,'%')",[$search_text]);
        $fields->select('id', 'name as text');
        $fields->orderBy('name','ASC');
        return $fields->paginate(10);
    }

    public function name_check(Request $request){
        $check = Data::where('name', $request->name)->first();
        if($check)
            return ["status"=>1,"message"=>"Item", "data"=>$check];
        return ["status"=>0,"message"=>"Not Found",];
    }

    public function add_to_list(Request $request){
        $name = trim($request->name);
        if($request->is_link == 1){ 
            if( !$name){
                return ["status"=>0, "message"=>"Please select a data name"];
            }
            $this->validate($request, [
                "model"  =>  "required",
            ]);

            $data_model = DataModel::where('type', $request->model)->first();
            if(!$data_model){
                return ["status"=>0, "message"=>"Model invalidated."];
            }
            
            //Select
            $project_data = Data::where('name', $name)->first();
            if($project_data && $project_data->id == $request->data_id){
                return ["status"=>0, "message"=>"Cannot link to own."];
            }
            //Create if not exists
            else if(!$project_data){
                $project_data = Data::create([
                    "name"=>$name,
                    "details"=>"",
                    "data_model_type"=>$request->model,
                    "data_model_id"=>$data_model->id
                ]);
            }
            //Add to field value
            //
            $value_check = DataModelFieldValue::where([
                "project_data_id"=>$request->data_id,
                "value_target"=>3,
                "value3"=>$project_data->id,
                "data_model_field_id"=>$request->data_model_field_id
            ])->first(); 
            if($value_check){
                return ["status"=>0, "message"=>"Already exists."];
            }
            $count = DataModelFieldValue::where(["project_data_id"=>$request->data_id, "data_model_field_id"=>$request->data_model_field_id])->count() + 1;
           
            $project_value = DataModelFieldValue::create([
                "order_id"=>$count,
                "order_no"=>$count,
                "project_data_id"=>$request->data_id,
                "type"=>$request->model,
                "data_type"=>$request->model,
                "value_target"=>3,
                "value3"=>$project_data->id,
                "data_model_field_id"=>$request->data_model_field_id
            ]);
            $project_value = DataModelFieldValue::with(['link_data'])->find($project_value->id);

        }else{
            if(!$name){
                return ["status"=>0, "message"=>"Data value is required."];
            }

            $project_value = null;
        }


        return ["status"=>1, "message"=>"Added Successfully.", "data"=>$project_value ];
    }

    public function add(Request $request){

        //Check if already exists by name
        $exists = Data::where('name', $request->name)->first();
        if($exists){
            return ["status"=>0, "message"=>"Name Already Exists."];
        }

        $user_id = auth()->user()->id;
        $session_id = session()->getId();
        $user_admin = null;
        if($session_id)
            $user_admin = \iProtek\Core\Models\UserAdminPayAccount::where(['user_admin_id'=>$user_id, 'browser_session_id'=>$session_id])->first();
 
        if(!$user_admin)
            $user_admin = UserAdminPayAccount::where('user_admin_id',$user_id)->first();

        if(!$user_admin){
            return ["status"=>0, "message"=>"User Admin not found."];
        } 

        $Data = Data::create([
            "name"=>$request->name,
            "details"=>$request->details,
            "data_model_id"=>$request->data_model_id,
            "data_model_type"=>$request->data_model_type
        ]);


        return ["status"=>1, "message"=>"Successfully Added", "data"=>$Data];
    }

    public function update(Request $request, Data $id){

        //Check if already exists by name
        $exists = Data::where('name', $request->name)->whereRaw(" id <> ?",[$id->id])->first();
        if($exists){
            return ["status"=>0, "message"=>"Name already exists."];
        }
        
        $user_id = auth()->user()->id;
        $session_id = session()->getId();
        $user_admin = null;
        if($session_id)
            $user_admin = \iProtek\Core\Models\UserAdminPayAccount::where(['user_admin_id'=>$user_id, 'browser_session_id'=>$session_id])->first();
 
        if(!$user_admin)
            $user_admin = UserAdminPayAccount::where('user_admin_id',$user_id)->first();
        
        if(!$user_admin){
            return ["status"=>0, "message"=>"User Admin not found."];
        } 

        $id->name = $request->name;
        $id->details = $request->details;
        if($id->isDirty()){
            //$id->data_model_id = $request->data_model_id;
            $id->pay_updated_by = $user_admin->pay_app_user_account_id;
            //$id->data_model_type = $request->data_model_type;
            $id->save();
        }

        return ["status"=>1, "message"=>"Successfully Updated", "data"=>$id];


    }

    
    public function data_value(Request $request, DataModelField $id){
        
        $this->validate($request, [
            "data_id"  =>  "required",
            //"data_type"=>"required",
        ]);

        $modelField = ModelField::find($id->model_field_id);
        if(!$modelField){
            return ["status"=>0, "message"=>"Field not found.".$id->model_field_id];
        }


        if( in_array($modelField->data_type, ["text", "date", "bool"]) ){
            $value = DataModelFieldValue::where([
                'project_data_id'=> $request->data_id,
                'data_model_id'=> $id->data_model_id,
                'data_model_field_id'=>$id->id
                ])->first();
            if($value){
                if($modelField->data_type == 'text'){
                    $value->value2 = $request->value;
                }
                else{
                    $value->value1 = $request->value;
                }
                $value->save();
            }else{ 
                $val_target= $modelField->data_type == 'text' ? 2:1;
               $value = DataModelFieldValue::create([
                    "order_id"=>$request->order_id,
                    "data_model_id"=>$id->data_model_id,
                    "data_model_field_id"=>$id->id,
                    "type"=>$modelField->data_type,
                    "value_target"=> $val_target,
                    "value1"=>$val_target == 1 ? $request->value : null,
                    "value2"=>$val_target == 2 ? $request->value : null,
                    "data_type"=>$modelField->data_type,
                    "project_data_id"=>$request->data_id
                ]);
                
            }

            return ["status"=>1, "message"=>"Field value updated.".$value->id];
        }


        return ["status"=>1, "message"=>"Field value updated."];
    }


}
