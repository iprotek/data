<?php

namespace iProtek\Data\Helpers; 
use DB;
use iProtek\Data\Models\DataModel;
use iProtek\Data\Models\DataModelField;
use iProtek\Data\Models\DataModelFieldValue;
use iProtek\Data\Models\DataDelegate;

class DataDelegateHelper
{  
    public static function get_data_delegate($source_id, $source_name, $key_name, $data_delegate_id = NULL){

        //GET FROM MODELS
        $datas =  DataDelegate::where('source_id', $source_id)->where('source_name', $source_name);

        if($data_delegate_id){
            $datas->where('id', $data_delegate_id);
        }
        $results = [];
        /**
         * id
         * key_name
         * placeholder
         * value
         * 
         */


        $delegates = $datas->get();

        //GET DATA FROM MODELS
        
        //GET DATA FROM VARIABLE

        //GET DATA FROM INPUTS




        return $results;
    }

}
