<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            Log::info("Not found error:".$e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => "Not found",
                'success' => false,
            ],404);
        });

        $exceptions->render(function (ErrorException $e, Request $request) {
            Log::info("server error:".$e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => "Something went wrong! Please try again.",
                'success' => false,
            ], 500);
        });

        $exceptions->render(function (ArgumentCountError $e, Request $request) {
            Log::info("Argument count error:".$e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => "Something went wrong! Please try again.",
                'success' => false,
            ], 500);
        });

        $exceptions->render(function (BadRequestHttpException $e, Request $request) {
            Log::error("Bad request error: " . $e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => "Something went wrong! Please try again.",
                'success' => false,
            ], 400);
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            Log::error("Authentication error: " . $e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => "Unauthenticated",
                'success' => false
            ], 401);
        });

        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, Request $request) {
            return response()->json([
                'message' => "Unauthorized Action",
                'success' => false
            ], 403);
        });

        $exceptions->render(function (\League\OAuth2\Server\Exception\OAuthServerException $e, Request $request) {
            return response()->json([
                'message' => "Invalid or expired token",
                'success' => false
            ], 401);
        });

        $exceptions->render(function (\Illuminate\Http\Exceptions\HttpResponseException $e, Request $request) {
            $response = $e->getResponse();
            Log::error("Http Response error: " . $e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => 'An error occurred.',
                'success' => 'failed'
            ], $response->getStatusCode());
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->validator->errors()
            ], 422);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            Log::error("Unexpected error: " . $e->getMessage().'- Line:- '.$e->getLine());
            return response()->json([
                'message' => 'Something went wrong! Please try again.',
                'success' => false
            ], 500);
        });
    })->create();

