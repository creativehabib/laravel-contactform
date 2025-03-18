<?php


use Habiblaravel\Contactform\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/contact', [ContactFormController::class, 'index']);
    Route::post('/submit/message', [ContactFormController::class, 'store'])->name('submit.message');
});
