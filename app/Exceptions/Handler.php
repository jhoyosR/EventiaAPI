<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Si la petición es API (que es tu caso)
        if ($request->expectsJson()) {

            // 404 - Modelo no encontrado
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Registro no encontrado'
                ], 404);
            }

            // Excepciones HTTP normales (401, 403, etc.)
            if ($e instanceof HttpException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }

            // 500 - Error interno
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        // Si no es una petición API, usa el render normal
        return parent::render($request, $e);
    }
}
