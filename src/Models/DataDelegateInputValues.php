<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDelegateInputValues extends Model
{
    use HasFactory;

    protected $fillable = [
        "data_delegate_id",
        "key_name",
        "input_value",
        "created_by",
        "updated_by"
    ];
}
