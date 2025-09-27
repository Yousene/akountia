<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Route non trouvée (404)
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Route API non trouvée: ' . $request->path());
                return response()->json([
                    'success' => false,
                    'message' => "Cette route n'existe pas",
                    'error' => 'Not Found'
                ], 404);
            }
        });

        // Méthode HTTP non autorisée (405)
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Méthode HTTP non autorisée: ' . $request->method() . ' ' . $request->path());
                return response()->json([
                    'success' => false,
                    'message' => 'Méthode HTTP non autorisée',
                    'error' => 'Method Not Allowed'
                ], 405);
            }
        });

        // Erreur de validation (422)
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Erreur de validation: ' . json_encode($e->errors()));
                return response()->json([
                    'success' => false,
                    'message' => 'Les données fournies sont invalides',
                    'error' => 'Validation Error',
                    'errors' => $e->errors()
                ], 422);
            }
        });

        // Non authentifié (401)
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Tentative d\'accès non authentifié: ' . $request->path());
                return response()->json([
                    'success' => false,
                    'message' => 'Authentification requise',
                    'error' => 'Unauthorized'
                ], 401);
            }
        });

        // Non autorisé (403)
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Accès non autorisé: ' . $request->path());
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas les permissions nécessaires',
                    'error' => 'Forbidden'
                ], 403);
            }
        });

        // Erreur de base de données (500)
        $this->renderable(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Erreur de base de données: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue avec la base de données',
                    'error' => 'Database Error',
                    'debug' => config('app.debug') ? [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode()
                    ] : null
                ], 500);
            }
        });

        // Toutes les autres exceptions (500)
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Erreur serveur: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());

                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur inattendue est survenue',
                    'error' => 'Internal Server Error',
                    'debug' => config('app.debug') ? [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ] : null
                ], 500);
            }
        });
    }

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
