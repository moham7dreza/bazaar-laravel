<?php

declare(strict_types=1);

namespace App\Http\Controllers\Examples;

use App\Enums\ExceptionCode;
use App\Exceptions\AuthorizationBusinessException;
use App\Exceptions\BaseBusinessException;
use App\Exceptions\BusinessAuthenticationException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\SystemException;
use App\Exceptions\ValidationBusinessException;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * Example Controller demonstrating how to use the custom exception system.
 *
 * This is a reference implementation - delete or move after reviewing
 */
class ExceptionExampleController
{
    /**
     * Example: Throwing a basic business exception.
     */
    public function basicException(): never
    {
        // Throw with automatic message from enum
        throw new BaseBusinessException(ExceptionCode::FeatureNotAvailable);
    }

    /**
     * Example: Throwing with custom message.
     */
    public function customMessage(): never
    {
        throw new BaseBusinessException(
            code: ExceptionCode::OperationNotAllowed,
            message: 'You cannot delete a published advertisement'
        );
    }

    /**
     * Example: Throwing with context data.
     */
    public function withContext(): never
    {
        throw new BaseBusinessException(
            code: ExceptionCode::InsufficientStock,
            context: [
                'requested_quantity' => 10,
                'available_quantity' => 3,
                'product_id'         => 123,
            ]
        );
    }

    /**
     * Example: Using specific exception classes.
     */
    public function specificExceptions(): never
    {
        // Authentication exception
        throw new BusinessAuthenticationException(
            code: ExceptionCode::TokenExpired,
            message: 'Your session has expired'
        );

        // Authorization exception
        throw new AuthorizationBusinessException(
            code: ExceptionCode::Forbidden,
            context: ['required_permission' => 'edit_ads']
        );

        // Resource not found
        throw new ResourceNotFoundException(
            resourceName: 'Advertisement',
            context: ['id' => 123]
        );

        // Validation exception
        throw new ValidationBusinessException(
            message: 'Invalid email format provided'
        );

        // System exception
        throw new SystemException(
            code: ExceptionCode::ExternalApiError,
            context: ['service' => 'payment-gateway']
        );
    }

    /**
     * Example: Business logic with exception.
     */
    public function checkStock(int $productId, int $quantity): JsonResponse
    {
        $availableStock = 5; // From database

        throw_if($quantity > $availableStock, BaseBusinessException::class, code: ExceptionCode::InsufficientStock, context: [
            'product_id' => $productId,
            'requested'  => $quantity,
            'available'  => $availableStock,
        ]);

        return new JsonResponse(['success' => true]);
    }

    /**
     * Example: Authorization check with exception.
     */
    public function authorizeAction(User $user): JsonResponse
    {
        if ($user->is_banned)
        {
            throw new AuthorizationBusinessException(
                code: ExceptionCode::AccountBanned,
                context: ['user_id' => $user->id]
            );
        }

        if ($user->is_suspended)
        {
            throw new AuthorizationBusinessException(
                code: ExceptionCode::AccountSuspended,
                context: [
                    'user_id'         => $user->id,
                    'suspended_until' => $user->suspended_until,
                ]
            );
        }

        return new JsonResponse(['success' => true]);
    }

    /**
     * Example: Multiple exception scenarios.
     */
    public function processPayment(int $orderId): JsonResponse
    {
        // Check if order exists
        $order = null; // From database
        throw_unless($order, ResourceNotFoundException::class, resourceName: 'Order', context: ['order_id' => $orderId]);

        // Check if order can be paid
        throw_if('paid' === $order->status, BaseBusinessException::class, code: ExceptionCode::OperationNotAllowed, message: 'This order has already been paid', context: ['order_id' => $orderId]);

        // Process payment
        $paymentResult = false; // From payment gateway
        throw_unless($paymentResult, BaseBusinessException::class, code: ExceptionCode::PaymentFailed, context: [
            'order_id' => $orderId,
            'gateway'  => 'stripe',
        ]);

        return new JsonResponse(['success' => true]);
    }

    /**
     * Example: Using ApiJsonResponse::throwException (alternative approach).
     */
    public function alternativeThrow(): never
    {
        ApiJsonResponse::throwException(
            status: 403,
            message: 'You cannot perform this action'
        );
    }
}
