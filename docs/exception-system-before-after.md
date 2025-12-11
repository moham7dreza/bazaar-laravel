# Exception System - Before vs After

## Before (Old System)

### Throwing Exceptions
```php
// Generic exception with magic numbers
throw new ApiJsonResponseException(403, ['Access denied']);

// No standard codes
throw new ApiJsonResponseException(422, ['Stock not available']);

// No context data
throw new Exception('Payment failed');
```

### Response Format
```json
{
    "data": null,
    "meta": {
        "status": 403,
        "messages": ["Access denied"]
    }
}
```

### Problems
❌ No standardized error codes  
❌ Magic numbers everywhere  
❌ No multi-language support  
❌ No developer/support messages  
❌ No context data for debugging  
❌ Inconsistent error handling  
❌ Hard to maintain  
❌ No type safety  

---

## After (New System)

### Throwing Exceptions
```php
// Standardized exception codes
throw new AuthorizationBusinessException(ExceptionCode::FORBIDDEN);

// Clear, descriptive codes
throw new BaseBusinessException(
    ExceptionCode::INSUFFICIENT_STOCK,
    context: ['product_id' => 123, 'available' => 3]
);

// Rich context data
throw new BaseBusinessException(
    ExceptionCode::PAYMENT_FAILED,
    context: ['gateway' => 'stripe', 'error' => 'card_declined']
);
```

### Response Format (Production)
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

### Response Format (Development)
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

### Benefits
✅ Standardized error codes (35 codes)  
✅ Type-safe enum-based codes  
✅ Multi-language support (EN, FA)  
✅ Multi-audience messages (client, dev, support)  
✅ Rich context data for debugging  
✅ Consistent error handling  
✅ Easy to maintain and extend  
✅ Automatic HTTP status mapping  
✅ Severity levels for logging  
✅ Conditional reporting  
✅ Fully tested (21 tests)  
✅ Comprehensive documentation  

---

## Migration Examples

### Example 1: Authorization Error

**Before:**
```php
if (!$user->can('edit_ads')) {
    throw new ApiJsonResponseException(403, ['Access denied']);
}
```

**After:**
```php
use App\Enums\ExceptionCode;
use App\Exceptions\AuthorizationBusinessException;

if (!$user->can('edit_ads')) {
    throw new AuthorizationBusinessException(
        ExceptionCode::FORBIDDEN,
        context: ['required_permission' => 'edit_ads']
    );
}
```

### Example 2: Validation Error

**Before:**
```php
if ($quantity < 1) {
    throw new ApiJsonResponseException(422, ['Invalid quantity']);
}
```

**After:**
```php
use App\Enums\ExceptionCode;
use App\Exceptions\ValidationBusinessException;

if ($quantity < 1) {
    throw new ValidationBusinessException(
        'Quantity must be at least 1',
        context: ['quantity' => $quantity]
    );
}
```

### Example 3: Resource Not Found

**Before:**
```php
$ad = Advertisement::find($id);
if (!$ad) {
    throw new ApiJsonResponseException(404, ['Advertisement not found']);
}
```

**After:**
```php
use App\Exceptions\ResourceNotFoundException;

$ad = Advertisement::find($id);
if (!$ad) {
    throw new ResourceNotFoundException('Advertisement', context: ['id' => $id]);
}

// Or even simpler with findOrFail:
$ad = Advertisement::findOrFail($id); // Automatically mapped to RES_3002
```

### Example 4: Business Logic Error

**Before:**
```php
if ($product->stock < $quantity) {
    throw new Exception('Not enough stock');
}
```

**After:**
```php
use App\Enums\ExceptionCode;
use App\Exceptions\BaseBusinessException;

if ($product->stock < $quantity) {
    throw new BaseBusinessException(
        ExceptionCode::INSUFFICIENT_STOCK,
        context: [
            'product_id' => $product->id,
            'requested' => $quantity,
            'available' => $product->stock,
        ]
    );
}
```

### Example 5: System Error

**Before:**
```php
try {
    $response = Http::post('https://payment-gateway.com/charge', $data);
} catch (Exception $e) {
    throw new Exception('Payment gateway error');
}
```

**After:**
```php
use App\Enums\ExceptionCode;
use App\Exceptions\SystemException;

try {
    $response = Http::post('https://payment-gateway.com/charge', $data);
} catch (Exception $e) {
    throw new SystemException(
        ExceptionCode::EXTERNAL_API_ERROR,
        context: [
            'service' => 'payment-gateway',
            'error' => $e->getMessage(),
        ],
        previous: $e
    );
}
```

---

## Error Code Comparison

### Before
- No standardized codes
- HTTP status only (403, 404, 422, 500)
- Hard to track error types
- No categorization

### After
- 35 standardized codes
- Categorized by type (AUTH, VAL, RES, BUS, SYS, RATE, CFG)
- Easy to track and analyze errors
- Automatic HTTP status mapping
- Support for error monitoring and analytics

---

## Developer Experience

### Before
```php
// What does this mean?
throw new ApiJsonResponseException(422, ['Error']);

// What category of error is this?
// What should the developer check?
// What should support do?
// Unknown! 😕
```

### After
```php
// Clear error category and code
throw new BaseBusinessException(ExceptionCode::INSUFFICIENT_STOCK);

// In development, you get:
// - Client message: "Insufficient stock available."
// - Developer message: "Stock quantity check failed..."
// - Support message: "Check inventory and restock..."
// - Context: { product_id: 123, requested: 10, available: 3 }
// - Code: BUS_4001
// Everything you need! 😊
```

---

## Monitoring & Analytics

### Before
- Hard to categorize errors
- No standard error codes
- Difficult to track error patterns
- Manual log parsing required

### After
- Every error has a unique code (BUS_4001, AUTH_1003, etc.)
- Easy to group and analyze errors
- Can track error trends by code
- Can set up alerts for specific codes
- Can generate error reports
- Can measure error rates by category

Example queries you can now run:
- "How many INSUFFICIENT_STOCK errors this week?"
- "Show me all AUTH_1003 (token expired) errors"
- "Alert me when SYS_5001 (internal error) rate exceeds 1%"

---

## Summary

| Aspect | Before | After |
|--------|--------|-------|
| Error Codes | ❌ None | ✅ 35 standardized codes |
| Type Safety | ❌ Magic numbers | ✅ Enum-based |
| Translations | ❌ No | ✅ EN + FA |
| Audiences | ❌ One message | ✅ Client, Dev, Support |
| Context Data | ❌ No | ✅ Yes |
| HTTP Mapping | ❌ Manual | ✅ Automatic |
| Testing | ❌ No tests | ✅ 21 tests, 100% pass |
| Documentation | ❌ None | ✅ Comprehensive |
| Maintainability | ❌ Hard | ✅ Easy |
| Developer Experience | ❌ Poor | ✅ Excellent |

---

## Conclusion

The new exception system provides:
- **Better error tracking** with standardized codes
- **Improved debugging** with context data
- **Better user experience** with translated messages
- **Better developer experience** with technical details
- **Better support experience** with troubleshooting hints
- **Better maintainability** with centralized management
- **Better reliability** with comprehensive testing

All your requirements have been met, plus many additional improvements! 🎉

