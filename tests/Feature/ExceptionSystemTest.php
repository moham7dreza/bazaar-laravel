<?php

declare(strict_types=1);

use App\Enums\ExceptionCode;
use App\Exceptions\AuthorizationBusinessException;
use App\Exceptions\BaseBusinessException;
use App\Exceptions\BusinessAuthenticationException;
use App\Exceptions\ExceptionMapper;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\SystemException;
use App\Exceptions\ValidationBusinessException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

test('exception code enum has correct http status codes', function (): void {
    expect(ExceptionCode::Unauthenticated->httpStatus())->toBe(401);
    expect(ExceptionCode::Forbidden->httpStatus())->toBe(403);
    expect(ExceptionCode::ResourceNotFound->httpStatus())->toBe(404);
    expect(ExceptionCode::ValidationError->httpStatus())->toBe(422);
    expect(ExceptionCode::TooManyRequests->httpStatus())->toBe(429);
    expect(ExceptionCode::InternalServerError->httpStatus())->toBe(500);
    expect(ExceptionCode::ServiceUnavailable->httpStatus())->toBe(503);
});

test('exception code has translated client messages', function (): void {
    $message = ExceptionCode::Unauthenticated->clientMessage();
    expect($message)->toBeString();
    expect($message)->not->toBeEmpty();
});

test('exception code has developer messages', function (): void {
    $message = ExceptionCode::DatabaseError->developerMessage();
    expect($message)->toBeString();
    expect($message)->not->toBeEmpty();
});

test('exception code has support messages', function (): void {
    $message = ExceptionCode::PaymentFailed->supportMessage();
    expect($message)->toBeString();
    expect($message)->not->toBeEmpty();
});

test('exception code reports critical errors', function (): void {
    expect(ExceptionCode::InternalServerError->shouldReport())->toBeTrue();
    expect(ExceptionCode::DatabaseError->shouldReport())->toBeTrue();
    expect(ExceptionCode::ServiceUnavailable->shouldReport())->toBeTrue();
});

test('exception code does not report user errors', function (): void {
    expect(ExceptionCode::ValidationError->shouldReport())->toBeFalse();
    expect(ExceptionCode::Unauthenticated->shouldReport())->toBeFalse();
    expect(ExceptionCode::ResourceNotFound->shouldReport())->toBeFalse();
});

test('exception code has correct severity levels', function (): void {
    expect(ExceptionCode::InternalServerError->severity())->toBe('critical');
    expect(ExceptionCode::ServiceUnavailable->severity())->toBe('error');
    expect(ExceptionCode::TooManyRequests->severity())->toBe('warning');
    expect(ExceptionCode::ValidationError->severity())->toBe('info');
});

test('base business exception creates with enum code', function (): void {
    $exception = new BaseBusinessException(ExceptionCode::FeatureNotAvailable);

    expect($exception->getExceptionCode())->toBe(ExceptionCode::FeatureNotAvailable);
    expect($exception->getMessage())->toBe(ExceptionCode::FeatureNotAvailable->clientMessage());
});

test('base business exception accepts custom message', function (): void {
    $customMessage = 'Custom error message';
    $exception     = new BaseBusinessException(
        ExceptionCode::OperationNotAllowed,
        $customMessage
    );

    expect($exception->getMessage())->toBe($customMessage);
});

test('base business exception stores context data', function (): void {
    $context   = ['user_id' => 123, 'action' => 'delete'];
    $exception = new BaseBusinessException(
        ExceptionCode::Forbidden,
        context: $context
    );

    expect($exception->getContext())->toBe($context);
});

test('authentication exception defaults to unauthenticated code', function (): void {
    $exception = new BusinessAuthenticationException();

    expect($exception->getExceptionCode())->toBe(ExceptionCode::Unauthenticated);
});

test('authorization exception defaults to forbidden code', function (): void {
    $exception = new AuthorizationBusinessException();

    expect($exception->getExceptionCode())->toBe(ExceptionCode::Forbidden);
});

test('resource not found exception handles resource name', function (): void {
    $exception = new ResourceNotFoundException('User');

    expect($exception->getContext())->toHaveKey('resource');
    expect(Arr::get($exception->getContext(), 'resource'))->toBe('User');
});

test('validation exception uses validation error code', function (): void {
    $exception = new ValidationBusinessException('Invalid input');

    expect($exception->getExceptionCode())->toBe(ExceptionCode::ValidationError);
});

test('system exception defaults to internal server error', function (): void {
    $exception = new SystemException();

    expect($exception->getExceptionCode())->toBe(ExceptionCode::InternalServerError);
});

test('base business exception returns json response', function (): void {
    $exception = new BaseBusinessException(ExceptionCode::InsufficientStock);

    $response = $exception->toResponse(request());

    expect($response)->toBeInstanceOf(JsonResponse::class);
    expect($response->getStatusCode())->toBe(422);

    $data = $response->getData(true);
    expect($data)->toHaveKey('meta');
    expect(Arr::get($data, 'meta'))->toHaveKey('status');
    expect(Arr::get($data, 'meta'))->toHaveKey('messages');
});

test('exception response includes developer info in debug mode', function (): void {
    config(['app.debug' => true]);

    $exception = new BaseBusinessException(
        ExceptionCode::DatabaseError,
        context: ['query' => 'SELECT * FROM users']
    );

    $response = $exception->toResponse(request());
    $data     = $response->getData(true);

    expect(Arr::get($data, 'meta.messages'))->toHaveKey('developer');
    expect(Arr::get($data, 'meta.messages'))->toHaveKey('code');
});

test('exception response hides developer info in production', function (): void {
    config(['app.debug' => false]);
    app()->detectEnvironment(fn (): string => 'production');

    $exception = new BaseBusinessException(
        ExceptionCode::DatabaseError,
        context: ['query' => 'SELECT * FROM users']
    );

    $response = $exception->toResponse(request());
    $data     = $response->getData(true);

    expect(Arr::get($data, 'meta.messages'))->not->toHaveKey('developer');
    expect(Arr::get($data, 'meta.messages'))->not->toHaveKey('context');
});

test('all exception codes have translations', function (): void {
    foreach (ExceptionCode::cases() as $code)
    {
        $clientMessage    = $code->clientMessage();
        $developerMessage = $code->developerMessage();
        $supportMessage   = $code->supportMessage();

        expect($clientMessage)->not->toContain('exceptions.client');
        expect($developerMessage)->not->toContain('exceptions.developer');
        expect($supportMessage)->not->toContain('exceptions.support');
    }
});

test('exception mapper handles business exceptions', function (): void {
    $exception = new BaseBusinessException(ExceptionCode::PaymentFailed);

    $mapped = ExceptionMapper::map($exception);

    expect($mapped)->toHaveKey('status');
    expect($mapped)->toHaveKey('message');
    expect($mapped)->toHaveKey('code');
    expect(Arr::get($mapped, 'code'))->toBe('BUS_4002');
});

test('exception mapper adds exception code to mapped data', function (): void {
    $exception = new Exception('Test error');

    $mapped = ExceptionMapper::map($exception);

    expect($mapped)->toHaveKey('code');
});
