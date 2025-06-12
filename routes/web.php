<?php

use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('assessment')->group(function () {
    Route::get('/', [AssessmentController::class, 'index'])->name('assessment.index');
    Route::post('/upload-adipura', [AssessmentController::class, 'uploadAdipura'])->name('assessment.upload.adipura');
    Route::get('/calculate-orisinal-adipura', [AssessmentController::class, 'calculateOrisinalAdipura'])->name('assessment.calculate.orisinal');
    Route::get('/calculate-koreksi-adipura', [AssessmentController::class, 'calculateKoreksiAdipura'])->name('assessment.calculate.koreksi');
});