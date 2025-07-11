<?php

namespace App\Core\Exceptions\Handlers;

use App\Core\Exceptions\Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Throwable;

class ExceptionsHandler extends LaravelExceptionHandler
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
        $e = $this->mapException($e);

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        }

        if($e instanceof Exception){
            return $e->toResponse($request);
        }

        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($response = $this->renderViaCallbacks($request, $e)) {
            return $response;
        }

        return match (true) {
            $e instanceof HttpResponseException => $e->getResponse(),
            $e instanceof AuthenticationException => $this->unauthenticated($request, $e),
            $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
            default => $this->renderExceptionResponse($request, $e),
        };
    }
}
