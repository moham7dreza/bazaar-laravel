# Custom Exception System Documentation

## Overview

This application uses a comprehensive custom exception system with:
- **Structured exception codes** organized by category (AUTH, VAL, RES, BUS, SYS, RATE, CFG)
- **Multi-audience messages** (client, developer, support)
- **Automatic translation support** (English & Persian)
- **HTTP status code mapping**
- **Context data** for debugging
- **Severity levels** for logging

## Architecture

### Components

1. **ExceptionCode Enum** (`app/Enums/ExceptionCode.php`)
   - Defines all exception codes with categorization
   - Maps codes to HTTP status codes
   - Provides translated messages for different audiences
   - Determines reporting and severity levels

2. **BaseBusinessException** (`app/Exceptions/BaseBusinessException.php`)
   - Base class for all custom business exceptions
   - Implements `Responsable` interface for automatic JSON responses
   - Supports context data for debugging
   - Handles message translation

3. **Specific Exception Classes**
   - `BusinessAuthenticationException` - Authentication failures
   - `AuthorizationBusinessException` - Authorization/permission failures
   - `ResourceNotFoundException` - Resource not found errors
   - `ValidationBusinessException` - Validation failures
   - `SystemException` - System/server errors

4. **ExceptionMapper** (`app/Exceptions/ExceptionMapper.php`)
   - Maps Laravel exceptions to our custom exception system
   - Provides backward compatibility

5. **Translation Files**
   - `lang/en/exception_codes.php` - English translations
   - `lang/fa/exception_codes.php` - Persian translations

## Exception Code Categories

### Authentication & Authorization (1xxx)
- `AUTH_1001` - Unauthenticated (401)
- `AUTH_1002` - Invalid Credentials (401)
- `AUTH_1003` - Token Expired (401)
- `AUTH_1004` - Token Invalid (401)
- `AUTH_1005` - Unauthorized (403)
- `AUTH_1006` - Forbidden (403)
- `AUTH_1007` - Email Not Verified (403)
- `AUTH_1008` - Mobile Not Verified (403)
- `AUTH_1009` - Account Suspended (403)
- `AUTH_1010` - Account Banned (403)

### Validation & Input (2xxx)
- `VAL_2001` - Validation Error (422)
- `VAL_2002` - Invalid Input (422)
- `VAL_2003` - Missing Required Field (422)
- `VAL_2004` - Invalid Format (422)
- `VAL_2005` - Duplicate Entry (422)

### Resources (3xxx)
- `RES_3001` - Resource Not Found (404)
- `RES_3002` - Model Not Found (404)
- `RES_3003` - Records Not Found (404)
- `RES_3004` - Multiple Records Found (422)

### Business Logic (4xxx)
- `BUS_4001` - Insufficient Stock (422)
- `BUS_4002` - Payment Failed (422)
- `BUS_4003` - Order Cannot Be Cancelled (422)
- `BUS_4004` - Feature Not Available (500)
- `BUS_4005` - Operation Not Allowed (422)
- `BUS_4006` - Quota Exceeded (422)

### System & Server (5xxx)
- `SYS_5001` - Internal Server Error (500)
- `SYS_5002` - Database Error (500)
- `SYS_5003` - Service Unavailable (503)
- `SYS_5004` - External API Error (500)
- `SYS_5005` - File Upload Failed (500)
- `SYS_5006` - Backup Failed (500)

### Rate Limiting (6xxx)
- `RATE_6001` - Too Many Requests (429)
- `RATE_6002` - Too Many Login Attempts (429)

### Configuration (7xxx)
- `CFG_7001` - Missing Configuration (500)
- `CFG_7002` - Invalid Configuration (500)

## Usage Examples

### Basic Exception

```php
use App\Enums\ExceptionCode;
use App\Exceptions\BaseBusinessException;

throw new BaseBusinessException(ExceptionCode::FEATURE_NOT_AVAILABLE);
```

### Exception with Custom Message

```php
throw new BaseBusinessException(
    code: ExceptionCode::OPERATION_NOT_ALLOWED,
    message: 'You cannot delete a published advertisement'
);
```

### Exception with Context Data

```php
throw new BaseBusinessException(
    code: ExceptionCode::INSUFFICIENT_STOCK,
    context: [
        'requested_quantity' => 10,
        'available_quantity' => 3,
        'product_id' => 123,
    ]
);
```

### Using Specific Exception Classes

```php
// Authentication
use App\Exceptions\BusinessAuthenticationException;

throw new BusinessAuthenticationException(
    code: ExceptionCode::TOKEN_EXPIRED,
    message: 'Your session has expired'
);

// Authorization
use App\Exceptions\AuthorizationBusinessException;

throw new AuthorizationBusinessException(
    code: ExceptionCode::FORBIDDEN,
    context: ['required_permission' => 'edit_ads']
);

// Resource Not Found
use App\Exceptions\ResourceNotFoundException;

throw new ResourceNotFoundException(
    resourceName: 'Advertisement',
    context: ['id' => 123]
);

// Validation
use App\Exceptions\ValidationBusinessException;

throw new ValidationBusinessException(
    message: 'Invalid email format provided'
);

// System
use App\Exceptions\SystemException;

throw new SystemException(
    code: ExceptionCode::EXTERNAL_API_ERROR,
    context: ['service' => 'payment-gateway']
);
```

### Real-World Example: Stock Check

```php
public function checkStock(int $productId, int $quantity): JsonResponse
{
    $availableStock = Product::find($productId)->stock;

    if ($quantity > $availableStock) {
        throw new BaseBusinessException(
            code: ExceptionCode::INSUFFICIENT_STOCK,
            context: [
                'product_id' => $productId,
                'requested' => $quantity,
                'available' => $availableStock,
            ]
        );
    }

    return response()->json(['success' => true]);
}
```

### Real-World Example: Authorization Check

```php
public function deleteAdvertisement(User $user, Advertisement $ad): JsonResponse
{
    if ($user->is_banned) {
        throw new AuthorizationBusinessException(
            code: ExceptionCode::ACCOUNT_BANNED,
            context: ['user_id' => $user->id]
        );
    }

    if ($ad->status === 'published') {
        throw new BaseBusinessException(
            code: ExceptionCode::OPERATION_NOT_ALLOWED,
            message: 'Cannot delete published advertisements',
            context: ['advertisement_id' => $ad->id]
        );
    }

    $ad->delete();
    return response()->json(['success' => true]);
}
```

## Response Format

### Production Environment
```json
{
    "data": null,
    "meta": {
        "status": 422,
        "messages": [
            "Insufficient stock available."
        ]
    }
}
```

### Development Environment (with debug=true)
```json
{
    "data": null,
    "meta": {
        "status": 422,
        "messages": {
            "0": "Insufficient stock available.",
            "developer": "Stock quantity check failed. Requested quantity exceeds available stock.",
            "support": "Stock insufficient for order. Check inventory and restock if needed.",
            "code": "BUS_4001",
            "context": {
                "product_id": 123,
                "requested": 10,
                "available": 3
            }
        }
    }
}
```

## Message Audiences

### Client Messages
- User-friendly, non-technical
- Safe to display in UI
- Available in multiple languages
- Example: "Insufficient stock available."

### Developer Messages
- Technical details about the error
- Troubleshooting hints for developers
- Stack trace references
- Example: "Stock quantity check failed. Requested quantity exceeds available stock."

### Support Messages
- Actionable troubleshooting steps
- Common causes and solutions
- What support staff should check
- Example: "Stock insufficient for order. Check inventory and restock if needed."

## Adding New Exception Codes

1. **Add to ExceptionCode Enum**
```php
case NEW_ERROR = 'CAT_X001';
```

2. **Add HTTP Status Mapping**
```php
public function httpStatus(): int
{
    return match ($this) {
        // ...existing cases...
        self::NEW_ERROR => Response::HTTP_BAD_REQUEST,
        // ...
    };
}
```

3. **Add Translations**

In `lang/en/exception_codes.php`:
```php
'client' => [
    'CAT_X001' => 'User-friendly message',
],
'developer' => [
    'CAT_X001' => 'Technical explanation',
],
'support' => [
    'CAT_X001' => 'Troubleshooting steps',
],
```

4. **Optional: Create Specific Exception Class**
```php
class MySpecificException extends BaseBusinessException
{
    public function __construct(
        ExceptionCode $code = ExceptionCode::NEW_ERROR,
        ?string $message = null,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($code, $message, $context, $previous);
    }
}
```

## Testing

All exception functionality is tested in `tests/Feature/ExceptionSystemTest.php`.

Run tests:
```bash
php artisan test --filter=ExceptionSystemTest
```

## Best Practices

1. **Use Specific Exception Classes** when available for better type hinting
2. **Always Include Context** for debugging complex scenarios
3. **Choose Appropriate Codes** that match the error category
4. **Write Clear Messages** that are actionable
5. **Test Exception Handling** in feature tests
6. **Log Critical Errors** - system errors are auto-reported
7. **Don't Expose Sensitive Data** in error messages

## Migration from Old System

The old `ApiJsonResponseException` is still supported but deprecated. Migrate to the new system:

### Before:
```php
throw new ApiJsonResponseException(403, ['Access denied']);
```

### After:
```php
throw new AuthorizationBusinessException(ExceptionCode::FORBIDDEN);
```

## Integration with Laravel

The exception system is integrated into `bootstrap/app.php`:
- Custom exceptions automatically render as JSON
- Reporting is controlled by `shouldReport()` method
- Context data is automatically logged
- Compatible with Laravel's exception handling

## Performance Considerations

- Exception codes are enums (zero overhead)
- Translations are lazy-loaded
- Context data is only included in debug mode
- Minimal impact on production performance

