<?php

use Illuminate\Support\Facades\Route;

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


use App\Http\Controllers\PhotoEditorController;

Route::get('/', [PhotoEditorController::class, 'index'])->name('home');
Route::get('/photo-editor', [PhotoEditorController::class, 'index'])->name('photo-editor.index');

Route::post('/photo-editor/process', [PhotoEditorController::class, 'process'])->name('photo-editor.process');