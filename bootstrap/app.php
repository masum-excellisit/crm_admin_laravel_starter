<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'customer' => \App\Http\Middleware\Customer::class,
            'TrackUserSession' => \App\Http\Middleware\TrackUserSession::class,
            'CheckSessionExists' => \App\Http\Middleware\CheckSessionExists::class,
            'UpdateLastActivity' => \App\Http\Middleware\UpdateLastActivity::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // 'stripe/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
