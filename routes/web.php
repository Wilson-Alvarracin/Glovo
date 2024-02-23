<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlovoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(GlovoController::class)->group(function (){
    Route::get('glovo','index')->name('glovo.index');
    Route::get('glovo/create','create')->name('glovo.create');
    Route::get('glovo/{id}','show')->name('glovo.show');
    Route::post('glovo','store')->name('glovo.store');
    Route::get('glovo/{id}/edit','edit')->name('glovo.edit');
    Route::put('glovo/{comic}','update')->name('glovo.update');
    Route::delete('glovo/{comic}','destroy')->name('glovo.destroy');
});