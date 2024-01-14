<?php

namespace App\Exceptions;

use App\Enums\Http\StatusCodeEnum;
use App\Http\Resources\V1\ErrorResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->errorResponseNotFound();
            }
        });
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->errorResponseNotFound();
            }
        });
    }

    private function errorResponseNotFound()
    {
        return (new ErrorResource(
            ['message' => __('messages.not_found')]
        ))
            ->response()
            ->setStatusCode(StatusCodeEnum::NOT_FOUND->value);
    }
}
