<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ExceptionCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

final readonly class ExceptionMapper
{
    public static function map(Throwable $e): array
    {
        // Handle custom business exceptions first
        if ($e instanceof BaseBusinessException)
        {
            return self::mapBusinessException($e);
        }

        return match (true)
        {
            $e instanceof AuthorizationException,
                $e instanceof AccessDeniedHttpException => [
                    'status'  => Response::HTTP_FORBIDDEN,
                    'message' => ExceptionCode::Forbidden->clientMessage(),
                    'code'    => ExceptionCode::Forbidden->value,
                ],

            $e instanceof AuthenticationException => [
                'status'  => Response::HTTP_UNAUTHORIZED,
                'message' => ExceptionCode::Unauthenticated->clientMessage(),
                'code'    => ExceptionCode::Unauthenticated->value,
            ],

            $e->getPrevious() instanceof ModelNotFoundException => [
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => self::getModelNotFoundMessage($e->getPrevious()),
                'code'    => ExceptionCode::ModelNotFound->value,
            ],

            $e instanceof QueryException => [
                'status'  => self::getQueryExceptionStatusCode($e),
                'message' => self::getQueryExceptionMessage($e),
                'code'    => ExceptionCode::DatabaseError->value,
            ],

            $e instanceof ValidationException => [
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $e->getMessage(),
                'code'    => ExceptionCode::ValidationError->value,
            ],

            $e instanceof RecordsNotFoundException => [
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => ExceptionCode::RecordsNotFound->clientMessage(),
                'code'    => ExceptionCode::RecordsNotFound->value,
            ],

            $e instanceof MultipleRecordsFoundException => [
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => ExceptionCode::MultipleRecordsFound->clientMessage(),
                'code'    => ExceptionCode::MultipleRecordsFound->value,
            ],

            default => [
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => app()->isProduction() ? ExceptionCode::InternalServerError->clientMessage() : $e->getMessage(),
                'code'    => ExceptionCode::InternalServerError->value,
            ],
        };
    }

    private static function mapBusinessException(BaseBusinessException $e): array
    {
        $exceptionCode = $e->getExceptionCode();
        $messages      = ['message' => $e->getMessage()];

        // Add developer and support messages in non-production
        if ( ! app()->isProduction() && config()->boolean('app.debug'))
        {
            $messages['developer'] = $exceptionCode->developerMessage();
            $messages['support']   = $exceptionCode->supportMessage();
            $messages['code']      = $exceptionCode->value;

            if (filled($e->getContext()))
            {
                $messages['context'] = $e->getContext();
            }
        }

        return [
            'status'  => $exceptionCode->httpStatus(),
            'message' => $messages,
            'code'    => $exceptionCode->value,
        ];
    }

    private static function getModelNotFoundMessage(ModelNotFoundException $e): string
    {
        $model = Str::afterLast($e->getModel(), '\\');

        return app()->isProduction() ? 'Record Not Found.' : "{$model} Not Found.";
    }

    private static function getQueryExceptionStatusCode(QueryException $e): int
    {
        return 1451 === Arr::get($e->errorInfo, 1)
            ? Response::HTTP_UNPROCESSABLE_ENTITY
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    private static function getQueryExceptionMessage(QueryException $e): string
    {
        return 1451 === Arr::get($e->errorInfo, 1)
            ? 'Unprocessable Entity'
            : 'Query Exception';
    }
}
