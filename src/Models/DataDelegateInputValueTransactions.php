<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDelegateInputValueTransactions extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "data_delegate_input_value_id",
        "from_val",
        "to_val",
        "updated_by"
    ];
}
