<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelField extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "name",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",
        "details",
        "json_info",
        "data_type",
        "has_date",
        "from",
        "to",
        "order_id"
    ];
}
