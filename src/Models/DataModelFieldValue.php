<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataModelFieldValue extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",

        "project_data_id",
        "parent_id",
        "data_model_id",
        "model_field_id",
        "data_model_field_id",
        "type", //model_field, data_model
        "value_target",
        "value1",
        "value2",
        "value3",
        "has_date",
        "from",
        "to",
        "data_type", //field, project, contact, person, company, 
        "order_no"
    ];

    public function link_data(){
        return $this->belongsTo( ProjectData::class, 'value3' );
    }

    public function project_data(){
        return $this->belongsTo(ProjectData::class, 'project_data_id' );
    }
}
