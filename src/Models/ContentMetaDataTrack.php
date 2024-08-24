<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentMetaDataTrack extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",

        "content_meta_data_id",
        "user_admin_id",
        "link_source_name",
        "link_ref"
    ];
    
    
    public $casts = [
        "created_at" => "datetime:Y-m-d H:i",
        "updated_at" => "datetime:Y-m-d H:i"
    ];
    

}
