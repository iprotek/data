<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{
    use HasFactory;

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
        "type",
        "address",
        "business_type",
        "status"
    ];
    
    public function fields(){
        return $this->hasMany(DataModelField::class, 'data_model_id')->orderBy('order_no','ASC');
    }
    
}
