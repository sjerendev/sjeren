<?php

use App\Http\Controllers\ContactFormController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// API routes should be handled by api.php
Route::prefix('api')->group(base_path('routes/api.php'));

// Contact form route
Route::post('/contact-form-submit', [ContactFormController::class, 'submit'])->name('contact.submit');

// Test route for mail debugging
Route::get('/test-mail', function () {
    try {
        Mail::raw('Test email at ' . now(), function($message) {
            $message->to('info@kalibercreative.se')
                   ->subject('Test Email');
        });
        return 'Mail sent successfully!';
    } catch (\Exception $e) {
        return 'Mail error: ' . $e->getMessage();
    }
});

// Catch-all route for Vue
Route::get('/{any?}', function () {
	return view('layouts.app');
})->where('any', '.*');
