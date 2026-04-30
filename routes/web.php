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
            Route::get('/',  [ 
                "uses"=>[DataModelController::class, 'index'],
                "description"=>"Data model index page",
                "is_visible"=>true,
                "is_allow"=>false
            ])->name('.index');
        });

        Route::prefix('model-fields')->name('.model-fields')->group(function(){
            Route::get('/',  [ 
                "uses"=> [ModelFieldController::class, 'index'],
                "description"=>"Model field index page",
                "is_visible"=>true,
                "is_allow"=>false 
            ])->name('.index'); 
        }); 

      });

    });

    //
    Route::prefix('iprotek-data')->name('.iprotek-data')->group(function(){

      Route::get('/models', [ 
        "uses"=> [SourceDataController::class, 'get_models'],
        "description"=>"Source of data models",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.get-models');
      //Route::get('/model-fields', [ SourceDataController::class, 'get_model_fields' ])->name('.get-models');
      
      //DATA DELEGATE
      Route::get('get-delegates', [
        "uses"=>[DataDelegateController::class, 'get_delegates'],
        "description"=>"Data delegates list",
        "is_visible"=>true,
        "is_allow"=>false 
      ])->name('.get-delegates');
      Route::post('add-delegate', [
        "uses"=>[DataDelegateController::class, 'add_delegate'],
        "description"=>"Add new data delegate",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.add-delegates');
      Route::put('update-delegate/{id}', [
        "uses"=>[DataDelegateController::class, 'edit_delegate'],
        "description"=>"Update existing data delegate",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.update-delegates');

      //GET VALUES
      Route::get('delegate-values', [
        "uses"=>[DataDelegateController::class, 'get_delegate_values'],
        "description"=>"Get delegate values",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.get-delegate-values');
      //update_delegate_values
      Route::put('update-delegate-values', [
        "uses"=>[DataDelegateController::class, 'update_delegate_values'],
        "description"=>"Update delegate values",
        "is_visible"=>true,
        "is_allow"=>false
      ])->name('.update-delegate-values');

    });

  });

});


include(__DIR__.'/api.php');