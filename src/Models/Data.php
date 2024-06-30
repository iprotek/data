<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Data\Helpers\DataFieldHelper;


class Data extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",
        "details",
        "json_info",
        "from",
        "to",
        "data_model_id",
        "data_model_type",
        "address",
        "business_type",
        "status",
        "ref_id",
        "ref_source"
    ];

    public function data_model(){
        return $this->belongsTo(DataModel::class, 'data_model_id');
    }


    //Function not a relationship
    public function fields_values(){

        $result = null;

        //DataModel
        $dataModel = DataModel::find($this->data_model_id);

        //DataModelFieldValue
        
        $result = DataModel::with(['fields'=>function($q){
            $q->with('model_field');
        }])->find($this->data_model_id);

        $fields = $result->fields;

        $arranged = DataFieldHelper::fieldsgetSub($fields, 0);
        //Arrange here
        $id->fieldList = $arranged;


        return $result;
    }
}
