<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Core\Http\Controllers\Manage\FileUploadController; 
use iProtek\Core\Http\Controllers\AppVariableController;
use iProtek\Data\Http\Controllers\DataModelController;
use iProtek\Data\Http\Controllers\DataController;
use iProtek\Data\Http\Controllers\ModelFieldController;
 
Route::prefix('api')->middleware(['api'])->group(function(){
    
    Route::prefix('group/{group_id}')->middleware(['pay.api', 'policy.control'])->name('api.data-model')->group(function(){
        
      Route::prefix('iprotek-data')->group(function(){
        Route::prefix('searches')->name('.searches')->group(function(){
            
            Route::get('/',  [ 
                "uses"=>[DataModelController::class, 'index'],
                "description"=>"Data model index page",
                "is_visible"=>true,
                "is_allow"=>false
            ])->name('.index');

            Route::prefix('data')->name('.data')->group(function(){
                Route::post('/add', [ 
                    "uses"=>[ DataController::class, 'add'],
                    "description"=>"Add new data record",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.add');
                Route::put('/update/{id}', [ 
                    "uses"=>[ DataController::class, 'update'],
                    "description"=>"Update existing data record",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.update');
                Route::get('/list', [ 
                    "uses"=>[ DataController::class, 'list'],
                    "description"=>"Get list of data records",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.list');
                Route::get('/get/{id}',  [ 
                    "uses"=>[ DataController::class, 'get'],
                    "description"=>"Get specific data record",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.get'); 
                Route::get('/list-selection', [ 
                    "uses"=>[ DataController::class, 'list_selection'],
                    "description"=>"Get list of data records for selection",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.list-selection');
                Route::get('/contact-projects/{id}', [ 
                    "uses"=>[ DataController::class, 'contact_projects'],
                    "description"=>"Get contact projects",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.contact-projects');
                Route::post('/name-check', [ 
                    "uses"=>[ DataController::class, 'name_check'],
                    "description"=>"Check if data name is available",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.name-check');
                
                Route::post('/add-to-list', [ 
                    "uses"=>[ DataController::class, 'add_to_list'],
                    "description"=>"Add data record to list",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.add-to-list');

                Route::post('/data-value/{id}', [ 
                    "uses"=>[ DataController::class, 'data_value'],
                    "description"=>"Set data value",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.data-value');
            
            }); 

        });

        Route::prefix('model-fields')->name('.model-fields')->group(function(){

            Route::get('/',  [ 
                "uses"=> [ModelFieldController::class, 'index'],
                "description"=>"Model field index page",
                "is_visible"=>true,
                "is_allow"=>false 
            ])->name('.index'); 

            Route::prefix('field')->name('.field')->group(function(){
                Route::get('/list', [ 
                    "uses"=> [ModelFieldController::class, 'list'],
                    "description"=>"Get list of model fields",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.list');
                Route::get('/list-selection', [ 
                    "uses"=> [ModelFieldController::class, 'list_selection'],
                    "description"=>"Get list of model fields for selection",
                    "is_visible"=>false,
                    "is_allow"=>true
                ])->name('.list-selection');
                Route::post('/add', [ 
                    "uses"=> [ModelFieldController::class, 'add'],
                    "description"=>"Add new model field",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.add');
                Route::put('/update/{id}', [ 
                    "uses"=> [ModelFieldController::class, 'update'],
                    "description"=>"Update existing model field",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.update');
                Route::delete('/{id}', [ 
                    "uses"=> [ModelFieldController::class, 'remove'],
                    "description"=>"Remove model field",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.remove');
            });
            
            Route::prefix('model')->name('.model')->group(function(){
                Route::get('/list', [ 
                    "uses"=> [DataModelController::class, 'list'],
                    "description"=>"Get list of data models",
                    "is_visible"=>true,
                    "is_allow"=>true
                ])->name('.list');
                Route::post('/add', [ 
                    "uses"=> [DataModelController::class, 'add'],
                    "description"=>"Add new data model",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.add');
                Route::get('/get/{id}', [ 
                    "uses"=> [DataModelController::class, 'get'],
                    "description"=>"Get data model by ID",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.get');
                Route::get('/list-selection', [ 
                    "uses"=> [DataModelController::class, 'list_selection'],
                    "description"=>"Get list of data models for selection",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.list-selection');
                Route::put('/update/{id}', [ 
                    "uses"=> [DataModelController::class, 'update'],
                    "description"=>"Update existing data model",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.update');
                Route::delete('/{id}', [ 
                    "uses"=> [DataModelController::class, 'remove'],
                    "description"=>"Remove data model",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.remove');
            });
        });
      });
    });
});