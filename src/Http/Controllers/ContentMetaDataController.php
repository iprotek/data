<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use Illuminate\Routing\Controller as BaseController;  
use iProtek\Core\Helpers\PayModelHelper;
use iProtek\Data\Models\ContentMetaData; 

class ContentMetaDataController extends BaseController
{
    //
    protected $guard = 'admin';

    public function get_info(Request $request, $id){
        /*
        $meta = ContentMetaData::find($id);
        if(!$meta)
            abort(403, 'Not Found');

        //*/
        $source = $request->souce;
        
        $id = PayModelHelper::get_own(ContentMetaData::class, $request, [
            "source"=>$source
        ])->first();


        return $id;
    }

    public function add(Request $request){

        return ["status"=>1, "message"=>"Successfully added MetaData"];
    }

    public function update(Request $request){

        return ["status"=>1, "message"=>"Successfully updated MetaData"];
    }

    public function remove(Request $request){

        return ["status"=>1, "message"=>"Successfully removed MetaData"];
    }


}
