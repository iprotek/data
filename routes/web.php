<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Data\Http\Controllers\DataModelController;
use iProtek\Data\Http\Controllers\DataController;
use iProtek\Data\Http\Controllers\ModelFieldController;
use iProtek\Data\Http\Controllers\SourceDataController;
use iProtek\Data\Http\Controllers\DataDelegateController;
use iProtek\Data\Http\Controllers\DataDelegateInputValuesController;
use iProtek\Data\Http\Controllers\DataDelegateInputValueTransactionsController;

//Route::prefix('sms-sender')->name('sms-sender')->group(function(){
  //  Route::get('/', [SmsController::class, 'index'])->name('.index');
//});

Route::middleware('web')->group(function(){
  
    
  Route::prefix('manage')->name('manage')->middleware(['auth:admin'])->group(function(){
    
    Route::middleware(['auth_web_pay_checker', 'pay.account'])->group(function(){

      Route::prefix('iprotek-data')->group(function(){
        Route::prefix('searches')->name('.searches')->group(function(){
            Route::get('/', [DataModelController::class, 'index'])
                ->defaults("_description", "Data model index page")
                ->defaults("_is_visible", true)
                ->defaults("_is_allow", false)
                ->name('.index');
        });

        Route::prefix('model-fields')->name('.model-fields')->group(function(){
            Route::get('/', [ModelFieldController::class, 'index'])
                ->defaults("_description", "Model field index page")
                ->defaults("_is_visible", true)
                ->defaults("_is_allow", false)
                ->name('.index'); 
        }); 

      });

    });

    //
    Route::prefix('iprotek-data')->name('.iprotek-data')->group(function(){

      Route::get('/models', [SourceDataController::class, 'get_models'])
        ->defaults("_description", "Source of data models")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.get-models');
      //Route::get('/model-fields', [ SourceDataController::class, 'get_model_fields' ])->name('.get-models');
      
      //DATA DELEGATE
      Route::get('get-delegates', [DataDelegateController::class, 'get_delegates'])
        ->defaults("_description", "Data delegates list")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.get-delegates');
      Route::post('add-delegate', [DataDelegateController::class, 'add_delegate'])
        ->defaults("_description", "Add new data delegate")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.add-delegates');
      Route::put('update-delegate/{id}', [DataDelegateController::class, 'edit_delegate'])
        ->defaults("_description", "Update existing data delegate")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.update-delegates');

      //GET VALUES
      Route::get('delegate-values', [DataDelegateController::class, 'get_delegate_values'])
        ->defaults("_description", "Get delegate values")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.get-delegate-values');
      //update_delegate_values
      Route::put('update-delegate-values', [DataDelegateController::class, 'update_delegate_values'])
        ->defaults("_description", "Update delegate values")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.update-delegate-values');

    });

  });

});


include(__DIR__.'/api.php');