<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'data',
    'as' => 'data.',
], function () {
    // index
    Route::get('', [DataController::class, 'index'])->name('index'); // data.index

    // store
    Route::post('', [DataController::class, 'store']);

    // update
    Route::put('', [DataController::class, 'update'])->name('update'); // data.update

    // destroy
    Route::delete('load', [DataController::class, 'destroy'])->name('destroy'); // data.destroy

    // load index data
    Route::get('load', [DataController::class, 'loadData']);
});