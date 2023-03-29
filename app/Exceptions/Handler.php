<?php

namespace App\Exceptions;

use App\Exceptions\Auth\AuthenticateException;
use DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    private const PRODUCTION_MESSAGE_STUB = 'Что-то пошло не так.';

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): BaseResponse
    {
        if ($this->isProd()) {
            return $this->productionResponse($e);
        }

        return $this->devResponse($e);
    }

    private function isProd(): bool
    {
        return !config('app.debug');
    }

    private function productionResponse(Throwable $e): JsonResponse
    {
        return $this->createJsonResponse($e, [
            'message' => $this->productionMessage($e),
        ]);
    }

    private function createJsonResponse(Throwable $e, array $payload): JsonResponse
    {
        $code = $e->getCode();

        return response()->json($payload, $code === 0 ? 500 : $code);
    }

    private function productionMessage(Throwable $e): string
    {
        $message = self::PRODUCTION_MESSAGE_STUB;

        if ($e instanceof DomainException || $e instanceof AuthenticateException) {
            $message = $e->getMessage();
        }

        return $message;
    }

    private function devResponse(Throwable $e): JsonResponse
    {
        return $this->createJsonResponse($e, [
            'message' => $e->getMessage(),
            'errors' => method_exists($e, 'getOptions') ? $e->getOptions() : [],
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
        ]);
    }

    public function report(Throwable $e): void
    {
        Log::channel('exception_handler')
            ->error(
                'AUTHORIZED USER: ' . (Auth::guest() ? 'unauthorized' : Auth::id())
                . ' '
                . $e
                . PHP_EOL
                . $e->getTraceAsString()
                . PHP_EOL
            );
    }
}
