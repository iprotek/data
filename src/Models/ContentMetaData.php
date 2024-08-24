<?php

namespace iProtek\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\FileUpload;
use Illuminate\Support\Facades\Log;

class ContentMetaData extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",

        "source",
        "source_id",
        "meta_data",
        "meta_ref"
        
    ];

    protected $casts = [
        "meta_data"=>"json"
    ];


    public function meta_image(){
        //$gg =  //var_dump(json_encode($this));
        
        return $this->hasMany(FileUpload::class, 'target_id','meta_ref')->where('target_name', 'meta-data-image')->orderBy('is_default', 'DESC');
    }
}
