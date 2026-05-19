<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'session.check' => \App\Http\Middleware\SessionCheck::class,
        'check.maintenance' => \App\Http\Middleware\CheckMaintenance::class,
        'force.password.change' => \App\Http\Middleware\ForcePasswordChange::class,
        'admin.only' => \App\Http\Middleware\AdminOnly::class,
        'prevent.back' => \App\Http\Middleware\PreventBackHistory::class,
    ]);
 })
    

        //global middleware
        // $middleware->append(\App\Http\Middleware\PromotionMw::class);

        //middleware group
        // $middleware->group('group_middleware',[
        //     \App\Http\Middleware\MiddlewareOne::class,
        //     \App\Http\Middleware\MiddlewareTwo::class,  
        // ]);

        //route middleware
    //     $middleware->alias(['maintenance' => \App\Http\Middleware\CheckMaintenance::class]);
    // });
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();