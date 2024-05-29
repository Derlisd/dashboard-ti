<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemSoldController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VPaymentController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\Auth\LoginController;

   Auth::routes(['register' => false]);


   Route::view('/token', 'validate_token');
   // Route::view('/transaction', 'transaction');
   Route::post('/check-token', [LoginController::class,'checkToken'])->name('check_token');
   Route::post('/generate-token', [LoginController::class,'generateToken'])->name('generate_token');

 Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::post('get-operacion', [OperationController::class,'getOperacion'])->name('get_operacion');

    //CONTACT
    Route::view('/contact', 'contact');
    Route::post('get-contacts', [ContactController::class,'get_contacts'])->name('get_contacts');
    Route::post('edit_contact', [ContactController::class,'updateContact'])->name('update_contact');

    //TRANSACTION
    Route::view('/transaction', 'transaction');
    Route::post('get-transaction', [TransactionController::class,'get_transactions'])->name('get_transactions');
    Route::post('edit_transaction', [TransactionController::class,'updateTransaction'])->name('update_transaction');

    //ITEM SOLD
    Route::view('/item-sold', 'item_sold');
    Route::post('get-item-old', [ItemSoldController::class,'get_items_old'])->name('get_items_sold');
    Route::post('edit_item-old', [ItemSoldController::class,'update_item_sold'])->name('update_item_sold');

    //ITEM
    Route::view('/item', 'item');
    Route::post('get-items', [ItemController::class,'get_items'])->name('get_items');
    Route::post('edit_item', [ItemController::class,'updateItem'])->name('update_item');
    
    //Vpayment
    Route::view('/vpayment', 'vpayment');
    Route::post('get-vpayment', [VPaymentController::class,'get_vpayments'])->name('get_vpayments');
    Route::post('edit_vpayment', [VPaymentController::class,'updateVpayment'])->name('update_vpayment');
    
    //Auditoria
    Route::view('/audit', 'audit');
    Route::post('get-auditoria', [AuditController::class,'index_audit'])->name('get_audit');
    
    //SETTING
    Route::post('get-setting', [SettingController::class,'getSetting'])->name('get_setting');

    //USERS
    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::get('/users/create', [UserController::class,'create'])->name('users.create');
    Route::post('/users', [UserController::class,'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class,'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class,'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class,'destroy'])->name('users.destroy');

 
 });


