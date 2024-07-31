<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request; 

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;  
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use Illuminate\Support\Facades\Schema;

class SourceDataController extends _CommonController
{
    //
    public function get_models(){

        // Directory where your models are stored
        $modelPath = app_path('Models');
        $namespace = 'App\\Models\\';

        // Get all PHP files in the models directory
        $files = File::allFiles($modelPath);

        $models = [];
        $class_names = [];

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $class = $namespace . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                $models[] = $class;
                $class_names[] =  class_basename($class);
            }
        }
        return $class_names;
        // Output the list of models
        foreach ($models as $model) {
            $this->info($model);
        }

        return 0;
    }

    public function get_model_fields(Request $request){
        try{
            $columnList = [];
            $class = "\\App\\Models\\".$request->model_name;
            $model = new $class;
            $table = $model->getTable();

            // Get all columns for the model's table
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                foreach ($columns as $column) { 
                    $columnList[] = $column;
                }
            } else {
                
            }
            return $columnList;
        }catch(\Exception $ex){
            return [];
        }



    }


}
