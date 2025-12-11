<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;
use Symfony\Component\HttpFoundation\Response;

enum ExceptionCode: string
{
    use EnumDataListTrait;

    // Authentication & Authorization (1xxx)
    case Unauthenticated     = 'AUTH_1001';
    case InvalidCredentials  = 'AUTH_1002';
    case TokenExpired        = 'AUTH_1003';
    case TokenInvalid        = 'AUTH_1004';
    case Unauthorized        = 'AUTH_1005';
    case Forbidden           = 'AUTH_1006';
    case EmailNotVerified    = 'AUTH_1007';
    case MobileNotVerified   = 'AUTH_1008';
    case AccountSuspended    = 'AUTH_1009';
    case AccountBanned       = 'AUTH_1010';

    // Validation & Input (2xxx)
    case ValidationError       = 'VAL_2001';
    case InvalidInput          = 'VAL_2002';
    case MissingRequiredField  = 'VAL_2003';
    case InvalidFormat         = 'VAL_2004';
    case DuplicateEntry        = 'VAL_2005';

    // Resource (3xxx)
    case ResourceNotFound     = 'RES_3001';
    case ModelNotFound        = 'RES_3002';
    case RecordsNotFound      = 'RES_3003';
    case MultipleRecordsFound = 'RES_3004';

    // Business Logic (4xxx)
    case InsufficientStock        = 'BUS_4001';
    case PaymentFailed            = 'BUS_4002';
    case OrderCannotBeCancelled   = 'BUS_4003';
    case FeatureNotAvailable      = 'BUS_4004';
    case OperationNotAllowed      = 'BUS_4005';
    case QuotaExceeded            = 'BUS_4006';

    // System & Server (5xxx)
    case InternalServerError  = 'SYS_5001';
    case DatabaseError        = 'SYS_5002';
    case ServiceUnavailable   = 'SYS_5003';
    case ExternalApiError     = 'SYS_5004';
    case FileUploadFailed     = 'SYS_5005';
    case BackupFailed         = 'SYS_5006';

    // Rate Limiting (6xxx)
    case TooManyRequests       = 'RATE_6001';
    case TooManyLoginAttempts  = 'RATE_6002';

    // Configuration (7xxx)
    case MissingConfiguration = 'CFG_7001';
    case InvalidConfiguration = 'CFG_7002';

    /**
     * Get the HTTP status code for this exception code.
     */
    public function httpStatus(): int
    {
        return match ($this)
        {
            self::Unauthenticated,
            self::InvalidCredentials,
            self::TokenExpired,
            self::TokenInvalid => Response::HTTP_UNAUTHORIZED,

            self::Unauthorized,
            self::Forbidden,
            self::AccountSuspended,
            self::AccountBanned => Response::HTTP_FORBIDDEN,

            self::ValidationError,
            self::InvalidInput,
            self::MissingRequiredField,
            self::InvalidFormat,
            self::DuplicateEntry,
            self::MultipleRecordsFound,
            self::OrderCannotBeCancelled,
            self::OperationNotAllowed,
            self::InsufficientStock,
            self::PaymentFailed,
            self::QuotaExceeded => Response::HTTP_UNPROCESSABLE_ENTITY,

            self::ResourceNotFound,
            self::ModelNotFound,
            self::RecordsNotFound => Response::HTTP_NOT_FOUND,

            self::TooManyRequests,
            self::TooManyLoginAttempts => Response::HTTP_TOO_MANY_REQUESTS,

            self::ServiceUnavailable => Response::HTTP_SERVICE_UNAVAILABLE,

            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }

    /**
     * Get the translated client message.
     */
    public function clientMessage(): string
    {
        return trans("exception_codes.client.{$this->value}");
    }

    /**
     * Get the developer-friendly message.
     */
    public function developerMessage(): string
    {
        return trans("exception_codes.developer.{$this->value}");
    }

    /**
     * Get the support message with troubleshooting hints.
     */
    public function supportMessage(): string
    {
        return trans("exception_codes.support.{$this->value}");
    }

    /**
     * Check if this exception should be reported to logs.
     */
    public function shouldReport(): bool
    {
        return match ($this)
        {
            self::InternalServerError,
            self::DatabaseError,
            self::ServiceUnavailable,
            self::ExternalApiError,
            self::BackupFailed => true,

            default => false,
        };
    }

    /**
     * Get severity level for logging.
     */
    public function severity(): string
    {
        return match ($this)
        {
            self::InternalServerError,
            self::DatabaseError,
            self::BackupFailed => 'critical',

            self::ServiceUnavailable,
            self::ExternalApiError,
            self::MissingConfiguration,
            self::InvalidConfiguration => 'error',

            self::AccountSuspended,
            self::AccountBanned,
            self::TooManyRequests,
            self::TooManyLoginAttempts => 'warning',

            default => 'info',
        };
    }
}
