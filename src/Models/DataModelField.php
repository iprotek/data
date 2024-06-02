<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataModelField extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",
        "data_model_id",
        "model_field_id",
        "parent_id",
        "order_id",
        "order_no"
    ];

    public function model_field(){
        return $this->belongsTo(ProjectModelField::class, 'model_field_id');
    }


}
