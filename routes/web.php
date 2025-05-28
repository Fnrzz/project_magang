<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [CsvController::class, 'upload'])->name('csv.upload');
Route::post('/upload', [CsvController::class, 'import'])->name('csv.import');

Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');
Route::get('/assessment/subkomponen', [AssessmentController::class, 'getSubkomponenOptions'])->name('assessment.subkomponen');
Route::post('/assessment', [AssessmentController::class, 'calculate'])->name('assessment.calculate');