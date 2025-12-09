<?php

declare(strict_types=1);

namespace App\Exceptions;

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
        return match (true)
        {
            $e instanceof AuthorizationException,
                $e instanceof AccessDeniedHttpException => [
                    'status'  => Response::HTTP_FORBIDDEN,
                    'message' => 'AuthorizationException',
                ],

            $e instanceof AuthenticationException => [
                'status'  => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthenticated',
            ],

            $e->getPrevious() instanceof ModelNotFoundException => [
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => self::getModelNotFoundMessage($e->getPrevious()),
            ],

            $e instanceof QueryException => [
                'status'  => self::getQueryExceptionStatusCode($e),
                'message' => self::getQueryExceptionMessage($e),
            ],

            $e instanceof ValidationException => [
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $e->getMessage(),
            ],

            $e instanceof RecordsNotFoundException => [
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'Records not found.',
            ],

            $e instanceof MultipleRecordsFoundException => [
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Multiple Records found. Only one record allowed.',
            ],

            default => [
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ],
        };
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
