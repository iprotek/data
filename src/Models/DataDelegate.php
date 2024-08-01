<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataDelegate extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "source_id",
        "source_name",
        "placeholder",
        "field_info",
        "source_type",
        "created_by",
        "updated_by",
        "deleted_by"
    ];
}
