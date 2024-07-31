<?php

namespace iProtek\Data\Http\Controllers;

use Illuminate\Http\Request; 

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;  
use iProtek\Core\Http\Controllers\_Common\_CommonController;

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

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $class = $namespace . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                $models[] = $class;
            }
        }
        return $models;
        // Output the list of models
        foreach ($models as $model) {
            $this->info($model);
        }

        return 0;
    }


}
