<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        "status"
    ];

    public function data_model(){
        return $this->belongsTo(ProjectDataModel::class, 'data_model_id');
    }


    //Function not a relationship
    public function fields_values(){

        $result = null;

        //ProjectDataModel
        $dataModel = ProjectDataModel::find($this->data_model_id);

        //ProjectDataModelFieldValue
        
        $result = ProjectDataModel::with(['fields'=>function($q){
            $q->with('model_field');
        }])->find($this->data_model_id);

        $fields = $result->fields;

        $arranged = ProjectFieldHelper::fieldsgetSub($fields, 0);
        //Arrange here
        $id->fieldList = $arranged;


        return $result;
    }
}
