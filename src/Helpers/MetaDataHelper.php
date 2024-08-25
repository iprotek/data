<?php

namespace iProtek\Data\Helpers; 
use DB; 
use iProtek\Data\Models\ContentMetaData;
use iProtek\Data\Models\ContentMetaDataTrack;
use iProtek\Core\Models\FileUpload;
use iProtek\Core\Models\UserAdminPayAccount;
use iProtek\Core\Models\UserAdmin;

class MetaDataHelper
{ 
    public static function getDefaultMetaData($source, $source_id, $own_proxy_group_id = null){
        $test = ContentMetaData::with(['meta_image']);
        $data = null;
        if($own_proxy_group_id){
            $data = $test->where('meta_ref','LIKE',$own_proxy_group_id.'-'.$source_id.'-'.$source)->first();
        }

        if(!$data)
            $data =  $test->where('meta_ref','LIKE','%-'.$source_id.'-'.$source)->first();

        if(  $data && !$data->meta_image){
            $data->meta_image = static::getDefaultMetaDataImage($source, $source_id);
        }

        return $data;
    }

    public static function getDefaultMetaDataImage($source, $source_id){
        return FileUpload::where('target_name', 'meta-data-image')->where('target_id', ' LIKE ' , '%-'.$source_id.'-'.$source)->whereRaw(" target_id IN ( SELECT meta_ref FROM content_meta_data WHERE deleted_at IS NULL ) ")->first();
    }

    public static function getDefaultMetaByUser($source, $source_id, $user_admin_id, $link_source_name = "", $link_ref = ""){
        $proxy_group_id = null;
        $user_admin = null;
        if($user_admin_id){
            $user_admin = UserAdminPayAccount::where('user_admin_id', $user_admin_id)->first();
            if($user_admin){
                $proxy_group_id = $user_admin->own_proxy_group_id;
            }
        }


        $result = static::getDefaultMetaData($source, $source_id, $proxy_group_id);

        if($result && $user_admin && $link_source_name){
            static::RecordMeta($result, $user_admin, $link_source_name, $link_ref);
        }

        $id = 0;
        $title = "";
        $description = "";
        $keywords = "";
        $image_url = "";
        $author_name = "";
        if($result && $result->meta_data){
            $meta_data = json_decode( json_encode($result->meta_data) );
            if($meta_data){
                $title = $meta_data->title;
                $description = $meta_data->description;
                $keywords = $meta_data->keywords;
            }

            $author_info = UserAdminPayAccount::where('pay_app_user_account_id', $result->pay_created_by)->first();
            if($author_info){
                $user_info = UserAdmin::find($author_info->user_admin_id);
                if($user_info){
                    $author_name = $user_info->name;
                }

            }
        }

        if($result &&  $result->meta_image){
            $image_url = $result->meta_image->full_url;
        }

        return [
            "id"=>$id,
            "title"=>$title,
            "description"=>$description,
            "keywords"=>$keywords,
            "image_url"=>$image_url,
            "author"=>$author_name
        ];
    }



    public static function RecordMeta(ContentMetaData $metadata, UserAdminPayAccount $pay_account, $link_source_name, $link_ref = null){
        ContentMetaDataTrack::create([
            "group_id"=>$pay_account->pay_app_user_account_id,
            "content_meta_data_id"=>$metadata->id,
            "user_admin_id"=>$pay_account->user_admin_id,
            "link_source_name"=>$link_source_name,
            "link_ref"=>$link_ref
        ]);
    }
    
}
