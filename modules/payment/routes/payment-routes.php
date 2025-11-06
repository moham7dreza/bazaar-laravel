<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;

Route::prefix('payments')
    ->controller(PaymentController::class)
    ->group(function (): void {
        Route::post('create', 'store')->name('api.payment.create');
        Route::get('verify', 'verify')->name('api.payment.verify');
    });
