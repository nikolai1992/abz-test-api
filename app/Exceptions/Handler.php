<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPUnit\Event\Code\Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable|\Throwable $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }

        return parent::render($request, $exception);
    }
}
