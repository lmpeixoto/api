<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use VOSTPT\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Event endpoints: /v1/events/*
|--------------------------------------------------------------------------
|
*/

Route::prefix('v1/events')->name('events::')->group(function () {
    Route::get('/', [
        'as'   => 'index',
        'uses' => EventController::class.'@index',
    ]);

    Route::post('/', [
        'as'   => 'create',
        'uses' => EventController::class.'@create',
    ])->middleware('jwt-auth');

    Route::get('/{Event}', [
        'as'   => 'view',
        'uses' => EventController::class.'@view',
    ]);

    Route::patch('/{Event}', [
        'as'   => 'update',
        'uses' => EventController::class.'@update',
    ])->middleware('jwt-auth');

    Route::delete('/{Event}', [
        'as'   => 'delete',
        'uses' => EventController::class.'@delete',
    ])->middleware('jwt-auth');
});
