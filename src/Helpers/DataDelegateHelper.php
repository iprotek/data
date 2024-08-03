<?php

namespace iProtek\Data\Helpers; 
use DB;
use iProtek\Data\Models\DataModel;
use iProtek\Data\Models\DataModelField;
use iProtek\Data\Models\DataModelFieldValue;
use iProtek\Data\Models\DataDelegate;
use iProtek\Data\Models\DataDelegateInputValues;

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

        foreach($delegates as $del){
            //GET DATA FROM MODELS
            if($del->source_type == 'model'){

                $field_info = json_decode($del->field_info);

                if($field_info->source_instance == 'self'){
                    $model_info = "\\App\\Models\\".$field_info->model_selected;
                    $model = new $model_info;
                    $field_name = $field_info->field_selected;
                    if($model){   
                        $res = $model->find($del->source_id);
                        if($res){
                            $results[] = [
                                "id"=>$del->id,
                                "key_name"=>$key_name,
                                "placeholder"=>$del->placeholder,
                                "source_type"=>$del->source_type,
                                "value"=>$res->$field_name
                            ];
                            continue;
                        }
                    }
                    $results[] = [
                        "id"=>$del->id,
                        "key_name"=>$key_name,
                        "placeholder"=>$del->placeholder,
                        "source_type"=>$del->source_type,
                        "value"=>""
                    ]; 
                }
            }
        
            //GET DATA FROM VARIABLE
            else  if($del->source_type == 'instance'){ 
                $results[] = [
                    "id"=>$del->id,
                    "key_name"=>$key_name,
                    "placeholder"=>$del->placeholder,
                    "source_type"=>$del->source_type,
                    "value"=>""
                ]; 
            }

            //GET DATA FROM INPUTS
            else  if($del->source_type == 'input'){
                $val = null;
                $input_item = DataDelegateInputValues::where('data_delegate_id', $del->id)
                            ->where('key_name', $key_name)->first();
                if($input_item) $val = $input_item->input_value;
                $results[] = [
                    "id"=>$del->id,
                    "key_name"=>$key_name,
                    "placeholder"=>$del->placeholder,
                    "source_type"=>$del->source_type,
                    "field_info"=> json_decode( $del->field_info ),
                    "value"=>$val
                ]; 

            }


        }
        return $results;
    }

}
