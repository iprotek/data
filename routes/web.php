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
            Route::get('/',  [ DataModelController::class, 'index' ])->name('.index'); 
            //Route::get('/pay-accounts',  [ DataController::class, 'pay_accounts' ])->name('.pay-accounts'); 
            Route::prefix('data')->name('.data')->group(function(){
                Route::post('/add', [  DataController::class, 'add' ])->name('.add');
                Route::put('/update/{id}', [ DataController::class, 'update' ])->name('.update');
                Route::get('/list', [ DataController::class, 'list' ])->name('.list');
                Route::get('/get/{id}',  [ DataController::class, 'get' ])->name('.get'); 
                Route::get('/list-selection', [ DataController::class, 'list_selection' ])->name('.list-selection');
                Route::get('/contact-projects/{id}', [ DataController::class, 'contact_projects' ])->name('.contact-projects');
                Route::post('/name-check', [ DataController::class, 'name_check' ])->name('.name-check');
                
                Route::post('/add-to-list', [ DataController::class, 'add_to_list' ])->name('.add-to-list');

                Route::post('/data-value/{id}', [ DataController::class, 'data_value' ])->name('.data-value');
            
            }); 

        });

        Route::prefix('model-fields')->name('.model-fields')->group(function(){
            Route::get('/',  [ ModelFieldController::class, 'index' ])->name('.index'); 

            Route::prefix('field')->name('.field')->group(function(){
                Route::get('/list', [ ModelFieldController::class, 'list' ])->name('.list');
                Route::get('/list-selection', [ ModelFieldController::class, 'list_selection' ])->name('.list-selection');
                Route::post('/add', [ ModelFieldController::class, 'add' ])->name('.add');
                Route::put('/update/{id}', [ ModelFieldController::class, 'update' ])->name('.update');
                Route::delete('/{id}', [ ModelFieldController::class, 'remove' ])->name('.remove');
            });
            
            Route::prefix('model')->name('.model')->group(function(){
                Route::get('/list', [ DataModelController::class, 'list' ])->name('.list');
                Route::post('/add', [  DataModelController::class, 'add' ])->name('.add');
                Route::get('/get/{id}', [ DataModelController::class, 'get' ])->name('.get');
                Route::get('/list-selection', [ DataModelController::class, 'list_selection' ])->name('.list-selection');
                Route::put('/update/{id}', [ DataModelController::class, 'update' ])->name('.update');
                Route::delete('/{id}', [ DataModelController::class, 'remove' ])->name('.remove');
            });
        }); 

      });

    });

    //
    Route::prefix('iprotek-data')->name('.iprotek-data')->group(function(){

      Route::get('/models', [ SourceDataController::class, 'get_models' ])->name('.get-models');
      //Route::get('/model-fields', [ SourceDataController::class, 'get_model_fields' ])->name('.get-models');
      
      //DATA DELEGATE
      Route::get('get-delegates', [DataDelegateController::class, 'get_delegates'])->name('.get-delegates');
      Route::post('add-delegate', [DataDelegateController::class, 'add_delegate'])->name('.add-delegates');
      Route::put('update-delegate/{id}', [DataDelegateController::class, 'edit_delegate'])->name('.update-delegates');

      //GET VALUES
      Route::get('delegate-values', [DataDelegateController::class, 'get_delegate_values'])->name('.get-delegate-values');
      //update_delegate_values
      Route::put('update-delegate-values', [DataDelegateController::class, 'update_delegate_values'])->name('.update-delegate-values');

    });

  });

});


Route::middleware('api')->prefix('api')->group(function(){


});