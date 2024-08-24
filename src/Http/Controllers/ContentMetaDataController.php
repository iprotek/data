<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use Illuminate\Routing\Controller as BaseController;  
use iProtek\Core\Helpers\PayModelHelper;
use iProtek\Data\Models\ContentMetaData; 

class ContentMetaDataController extends _CommonController
{
    //
    protected $guard = 'admin';

    public function get_info(Request $request){ 

        $meta_ref = $request->group_id."-".$request->id;
        $data = PayModelHelper::get_own(ContentMetaData::class, $request)->where('meta_ref', $meta_ref)->with(['meta_image'])->first();
        if(!$data){
            return ContentMetaData::where('meta_ref','LIKE','%-'.$request->id)->with(['meta_image'])->first();
        }
        return $data;

    }

    public function add(Request $request){
        $meta = null;
        $this->validate($request, [
            "source_id"=>"required",
            "source"=>"required",
            "title"=>"required|min:10, max:50",
            "description"=>"required|max:130"
        ]);
        $meta_ref = $request->group_id."-".$request->source_id."-".$request->source;
        
        $meta =  PayModelHelper::get_own(ContentMetaData::class, $request)->where(['meta_ref'=> $meta_ref,"source_id"=>$request->source_id, "source"=>$request->source ])->first();
        if(!$meta){
            $meta = PayModelHelper::create_own(ContentMetaData::class, $request, [
                "source"=>$request->source,
                "source_id"=>$request->source_id,
                "meta_data"=>$request->meta_data,
                "meta_ref"=>$request->group_id."-".$request->source_id."-".$request->source
            ]);
            return ["status"=>1, "message"=>"Successfully added MetaData", "data"=> $meta];
        }
        else{
            //$meta->meta_data = $request->meta_data;
            PayModelHelper::update_own($meta, $request, [
                "meta_data"=>$request->meta_data
            ]);
            return ["status"=>1, "message"=>"Successfully updated MetaData", "data"=> $meta];
        } 
    }

    public function update(Request $request){

        return ["status"=>1, "message"=>"Successfully updated MetaData"];
    }

    public function remove(Request $request){

        $meta_ref = $request->group_id."-".$request->id;
        $data = PayModelHelper::get_own(ContentMetaData::class, $request)->where('meta_ref', $meta_ref);
        if($data){
            PayModelHelper::delete($data);
        }

        return ["status"=>1, "message"=>"Successfully removed MetaData"];
    }


}
