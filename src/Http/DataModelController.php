<?php

namespace iProtek\Data\Http\Controllers\Manage\ProjectsMonitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\_Common\_CommonController;  
use iProtek\Data\Models\DataModel;
use iProtek\Data\Models\DataModelField;
use App\Models\UserAdminPayAccount;
use App\Helpers\ProjectMonitoring\DataFieldHelper;


class  DataModelController extends _CommonController
{
    //
    public $guard = 'admin';
    public function index(Request $request){
        return $this->view('manage.projects.searches.index');

    }

    public function list(Request $request){
        
        $project_model_fields = ProjectDataModel::on();//BillingAccount::on(); 
        $search_text = str_replace(' ','%', $request->search?:"");
        $project_model_fields->whereRaw(" name LIKE CONCAT('%',?,'%')",[$search_text])->orderBy('name','ASC');
        return $project_model_fields->paginate(10);
    }

    
    public function list_selection(Request $request){
        $fields = ProjectDataModel::on();//BillingAccount::on(); 
        $search_text = str_replace(' ','%', $request->search_text?:"");
        $fields->whereRaw(" name LIKE CONCAT('%',?,'%')",[$search_text]);
        $fields->select('id', \DB::raw('CONCAT(name, " - [ ", type," ]")  as text'), 'type', 'name');
        $fields->orderBy('name','ASC');
        return $fields->paginate(10);
    }

    public function remove(Request $request, ProjectDataModel $id){
        //$id->delete();
        return ["status"=>1, "message"=>"Successfully Removed"];
    }

    public function update(Request $request, ProjectDataModel $id){
        $this->validate($request, [
            "name"      =>  "required"
        ]);
        
        $user_id = auth()->user()->id;

        //This should reference to raw table
        $user_admin = UserAdminPayAccount::where('user_admin_id',$user_id)->first();
        if(!$user_admin){
            return ["status"=>0, "message"=>"User Admin not found."];
        } 

        $id->pay_updated_by = $user_admin->pay_app_user_account_id;
        $id->name = $request->name;
        $id->details = $request->details;
        
        if($id->isDirty()){
            $id->save();
        }

        //Add fields on update
        $activated_fields = DataFieldHelper::setFields($request->fields, $id, 0, $user_admin->pay_app_user_account_id);

        //Delete fields not present on activated_fields
        $model_fields = ProjectDataModelField::where('data_model_id', $id->id)->whereNotIn('id', $activated_fields)->get();
        foreach($model_fields as $field){
            $field->pay_deleted_by = $user_admin->pay_app_user_account_id;
            $field->save();
            $field->delete();
        }

        
        return ["status"=>1, "message"=>"Successfully Updated. ".json_encode($activated_fields)];
    }

    public function get(Request $request, ProjectDataModel $id){

        $result = ProjectDataModel::with(['fields'=>function($q){
            $q->with('model_field');
        }])->find($id->id);

        $fields = $result->fields;

        $arranged = DataFieldHelper::fieldsgetSub($fields, 0);
        //Arrange here
        $id->fieldList = $arranged;


        return $id;
        //return $id;
    }

 

    
    public function add(Request $request){
        
        $this->validate($request, [
            "name"      =>  "required",
            "type" =>  "required"
        ]);

        $project_model_field =  ProjectDataModel::where('name', $request->name)->first();

        if($project_model_field){
            return ["status"=>0, "message"=>"Model name already Exists"];
        }

        //
        $user_id = auth()->user()->id;
        $user_admin = UserAdminPayAccount::where('user_admin_id',$user_id)->first();
        if(!$user_admin){
            return ["status"=>0, "message"=>"User Admin not found."];
        } 

        ProjectDataModel::create([
            "name"=>$request->name,
            "pay_created_by"=>$user_admin->pay_app_user_account_id,
            "type"=>$request->type,
            "details"=>$request->details
        ]);

        $activated_fields = DataFieldHelper::setFields($request->fields, $project_model_field, 0, $user_admin->pay_app_user_account_id);


        return ["status"=>1, "message"=>"Successfully Added.", "data"=>$project_model_field];

    }
}
