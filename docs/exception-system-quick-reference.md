# Exception System - Quick Reference

## Quick Start

### Throw a Basic Exception
```php
use App\Enums\ExceptionCode;
use App\Exceptions\BaseBusinessException;

throw new BaseBusinessException(ExceptionCode::OPERATION_NOT_ALLOWED);
```

### Throw with Custom Message
```php
throw new BaseBusinessException(
    ExceptionCode::INSUFFICIENT_STOCK,
    'Not enough items in stock',
    ['product_id' => 123, 'requested' => 10, 'available' => 3]
);
```

### Use Specific Exception Classes
```php
use App\Exceptions\{
    BusinessAuthenticationException,
    AuthorizationBusinessException,
    ResourceNotFoundException,
    ValidationBusinessException,
    SystemException
};

// Authentication
throw new BusinessAuthenticationException(ExceptionCode::TOKEN_EXPIRED);

// Authorization
throw new AuthorizationBusinessException(ExceptionCode::FORBIDDEN);

// Resource Not Found
throw new ResourceNotFoundException('User', context: ['id' => 123]);

// Validation
throw new ValidationBusinessException('Invalid email format');

// System Error
throw new SystemException(ExceptionCode::DATABASE_ERROR);
```

## Available Exception Codes

| Code | Category | HTTP Status | Description |
|------|----------|-------------|-------------|
| **AUTH_1xxx** | Authentication | 401/403 | Login, tokens, verification |
| **VAL_2xxx** | Validation | 422 | Input validation errors |
| **RES_3xxx** | Resources | 404/422 | Resource not found |
| **BUS_4xxx** | Business Logic | 422/500 | Business rule violations |
| **SYS_5xxx** | System | 500/503 | Server/system errors |
| **RATE_6xxx** | Rate Limiting | 429 | Too many requests |
| **CFG_7xxx** | Configuration | 500 | Config errors |

## Key Features

✅ **Multi-audience messages** - Client, Developer, Support  
✅ **Auto-translation** - English & Persian  
✅ **Context data** - Debug information in non-production  
✅ **HTTP status mapping** - Automatic status codes  
✅ **Severity levels** - Critical, Error, Warning, Info  
✅ **Reporting control** - Auto-report critical errors  
✅ **Fully tested** - 21 passing tests

## Files

- `app/Enums/ExceptionCode.php` - Exception code definitions
- `app/Exceptions/BaseBusinessException.php` - Base exception class
- `app/Exceptions/*Exception.php` - Specific exception classes
- `lang/*/exception_codes.php` - Translations
- `docs/exception-system.md` - Full documentation
- `tests/Feature/ExceptionSystemTest.php` - Test suite

## Example Controller

See `app/Http/Controllers/Examples/ExceptionExampleController.php` for comprehensive usage examples.

## Documentation

Full documentation: [docs/exception-system.md](./exception-system.md)

