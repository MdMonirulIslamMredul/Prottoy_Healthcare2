<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckSuperAdmin;
use App\Http\Middleware\CheckDivisionalChief;
use App\Http\Middleware\CheckDistrictManager;
use App\Http\Middleware\CheckUpazilaSupervisor;
use App\Http\Middleware\CheckPHO;
use App\Http\Middleware\CheckCustomer;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'superadmin' => CheckSuperAdmin::class,
            'divisionalchief' => CheckDivisionalChief::class,
            'districtmanager' => CheckDistrictManager::class,
            'upazilasupervisor' => CheckUpazilaSupervisor::class,
            'pho' => CheckPHO::class,
            'customer' => CheckCustomer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
