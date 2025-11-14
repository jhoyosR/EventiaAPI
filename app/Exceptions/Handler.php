<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        // Manejar excepciones para renderizar una respuesta HTTP personalizada
        $this->renderable(function (Throwable $e, $request) {

            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                // Verificar si la petición espera una respuesta JSON
                if ($request->expectsJson()) {
                    // Devuelve una respuesta JSON con el código de estado 404
                    return response()->json([
                        'message' => 'Registro no encontrado',
                        'result' => null,
                    ], 404);
                }
            }
        });
    }
}
