<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

//use App\Http\Middleware\PasetoAuth;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',//tambahan untuk api
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: '/api',//prefix untuk api
    )
    ->withMiddleware(function (Middleware $middleware) {
        //$middleware->append(PasetoAuth::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
