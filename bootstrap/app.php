<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',

        api: __DIR__ . '/../routes/api.php',
        // apiPrefix: 'api/',

        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ModelNotFoundException $e, Request $request): JsonResponse {
            return apiResponseWithStatusCode([], 'error', 'The requested resource was not found.', '', 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request): JsonResponse {
            return apiResponseWithStatusCode([], 'error', 'The resource you are trying to reach was not found.', '', 404);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            return apiResponseWithStatusCode([], 'error', 'You are not authorized to do this action.', '', 422);
        });
    })->create();
