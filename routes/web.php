<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [CsvController::class, 'upload'])->name('csv.upload');
Route::post('/upload', [CsvController::class, 'import'])->name('csv.import');
