<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\FileUpload;

class ContentMetaData extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",

        "source",
        "source_id",
        "meta_data"
        
    ];

    public $casts = [
        "meta_data"=>"json"
    ];

    public function meta_image(){
        return $this->hasMany(FileUpload::class, 'group_id', 'group_id' )->where('target_name','meta-data-image');
    }
}
