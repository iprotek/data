<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;  
use iProtek\Data\Models\ModelField;
use iProtek\Core\Models\UserAdminPayAccount;
use iProtek\Data\Models\DataModelFieldValue;
use iProtek\Core\Http\Controllers\_Common\_CommonController; 

class ModelFieldController extends _CommonController
{
    //
    public $guard = 'admin';
    public function index(Request $request){
        return $this->view('iprotek_data::manage.model-fields.index');
        
    }

    public function list(Request $request){
        
        $project_model_fields = ModelField::on();//BillingAccount::on(); 
        $search_text = str_replace(' ','%', $request->search?:"");
        $project_model_fields->whereRaw(" name LIKE CONCAT('%',?,'%')",[$search_text])->orderBy('name','ASC');
        return $project_model_fields->paginate(10);
    }

    public function list_selection(Request $request){
        $fields = ModelField::on();//BillingAccount::on(); 
        $search_text = str_replace(' ','%', $request->search_text?:"");
        $fields->whereRaw(" name LIKE CONCAT('%',?,'%')",[$search_text]);
        $fields->select('id', \DB::raw('CONCAT(name, " - [ ", data_type," ]")  as text'), 'data_type', 'name');
        $fields->orderBy('name','ASC');
        return $fields->paginate(10);
    }

    public function remove(Request $request, ModelField $id){
        $id->delete();
        return ["status"=>1, "message"=>"Successfully Removed"];
    }

    public function update(Request $request, ModelField $id){
        $this->validate($request, [
            "name"      =>  "required",
            //"data_type" =>  "required"
        ]);
        
        $user_id = auth()->user()->id;
        $user_admin = UserAdminPayAccount::where('user_admin_id',$user_id)->first();
        if(!$user_admin){
            return ["status"=>0, "message"=>"User Admin not found."];
        } 

        $id->pay_updated_by = $user_admin->pay_app_user_account_id;
        $id->name = $request->name;
        //$id->data_type = $request->data_type;
        $id->details = $request->details;
        if($id->isDirty()){
            $id->save();
        }


    
        
        return ["status"=>1, "message"=>"Successfully Updated." , "data"=>$id];
    }

    public function add(Request $request){
        
        $this->validate($request, [
            "name"      =>  "required",
            "data_type" =>  "required"
        ]);

        $project_model_field =  ModelField::where('name', $request->name)->first();

        if($project_model_field){
            return ["status"=>0, "message"=>"Field name already Exists"];
        }

        //
        $user_id = auth()->user()->id;
        $user_admin = UserAdminPayAccount::where('user_admin_id',$user_id)->first();
        if(!$user_admin){
            return ["status"=>0, "message"=>"User Admin not found."];
        } 

        $added = ModelField::create([
            "name"=>$request->name,
            "pay_created_by"=>$user_admin->pay_app_user_account_id,
            "data_type"=>$request->data_type,
            "details"=>$request->details
        ]);


        return ["status"=>1, "message"=>"Successfully Added.", "data"=> $added];

    }

}
