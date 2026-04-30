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
            
            Route::get('/',   [DataModelController::class, 'index'])
                ->defaults("_description","Data model index page")
                ->defaults("_is_visible", true)
                ->defaults("_is_allow", false)
                ->name('.index');

            Route::prefix('data')->name('.data')->group(function(){
                Route::post('/add',  [ DataController::class, 'add'])
                    ->defaults("_description", "Add new data record")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.add');
                Route::put('/update/{id}',  [ DataController::class, 'update'])
                    ->defaults("_description", "Update existing data record")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.update');
                Route::get('/list', [ DataController::class, 'list'])
                    ->defaults("_description", "Get list of data records")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.list');
                Route::get('/get/{id}',  [ DataController::class, 'get'])
                    ->defaults("_description", "Get specific data record")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.get'); 
                Route::get('/list-selection', [ DataController::class, 'list_selection'])
                     ->defaults("_description", "Get list of data records for selection")
                     ->defaults("_is_visible", false)
                     ->defaults("_is_allow", true)
                     ->name('.list-selection');
                Route::get('/contact-projects/{id}',  [ DataController::class, 'contact_projects'])
                    ->defaults("_description", "Get contact projects")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.contact-projects');
                Route::post('/name-check', [ DataController::class, 'name_check'])
                    ->defaults("_description", "Check if data name is available")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.name-check');
                
                Route::post('/add-to-list', [ DataController::class, 'add_to_list'])
                    ->defaults("_description", "Add data record to list")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.add-to-list');

                Route::post('/data-value/{id}', [ DataController::class, 'data_value'])
                    ->defaults("_description", "Set data value")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.data-value');
            
            }); 

        });

        Route::prefix('model-fields')->name('.model-fields')->group(function(){

            Route::get('/',  [ModelFieldController::class, 'index'])
                ->defaults("_description","Model field index page")
                ->defaults("_is_visible", true)
                ->defaults("_is_allow", false)
                ->name('.index'); 

            Route::prefix('field')->name('.field')->group(function(){
                Route::get('/list',  [ModelFieldController::class, 'list'])
                    ->defaults("_description", "Get list of model fields")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.list');
                Route::get('/list-selection',  [ModelFieldController::class, 'list_selection'])
                    ->defaults("_description", "Get list of model fields for selection")
                    ->defaults("_is_visible", false)
                    ->defaults("_is_allow", true)
                    ->name('.list-selection');
                Route::post('/add', [ModelFieldController::class, 'add'])
                    ->defaults("_description", "Add new model field")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.add');
                Route::put('/update/{id}', [ModelFieldController::class, 'update'])
                    ->defaults("_description", "Update existing model field")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.update');
                Route::delete('/{id}', [ModelFieldController::class, 'remove'])
                    ->defaults("_description", "Remove model field")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.remove');
            });
            
            Route::prefix('model')->name('.model')->group(function(){
                Route::get('/list', [DataModelController::class, 'list'])
                    ->defaults("_description", "Get list of data models")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", true)
                    ->name('.list');
                Route::post('/add', [DataModelController::class, 'add'])
                    ->defaults("_description", "Add new data model")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.add');
                Route::get('/get/{id}', [DataModelController::class, 'get'])
                    ->defaults("_description", "Get data model by ID")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.get');
                Route::get('/list-selection', [DataModelController::class, 'list_selection'])
                    ->defaults("_description", "Get list of data models for selection")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.list-selection');
                Route::put('/update/{id}', [DataModelController::class, 'update'])
                    ->defaults("_description", "Update existing data model")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.update');
                Route::delete('/{id}', [DataModelController::class, 'remove'])
                    ->defaults("_description", "Remove data model")
                    ->defaults("_is_visible", true)
                    ->defaults("_is_allow", false)
                    ->name('.remove');
            });
        });
      });
    });
});