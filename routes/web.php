<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', [QuizController::class, 'start']);
Route::post('/quiz/next/{qid}', [QuizController::class, 'next']);
Route::post('/quiz/submit', [QuizController::class, 'submit']);
