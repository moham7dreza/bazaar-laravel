<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\PricingUpdateFailed;
use App\Exceptions\InsufficientStockException;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function verifyStock($itemCode)
    {
        return Item::query()->where('code', $itemCode)
            ->where('quantity', '>', 0)
            ->existsOr(function () use ($itemCode) {
                Log::warning("Stock check attempted for unavailable item: {$itemCode}");

                return new JsonResponse([
                    'in_stock' => false,
                    'message'  => 'Item unavailable or out of stock',
                ], 404);
            });
    }

    public function reserveItem($itemId, $quantity)
    {
        return Item::query()->where('id', $itemId)
            ->where('available_quantity', '>=', $quantity)
            ->existsOr(function () use ($itemId, $quantity): void {
                throw new InsufficientStockException(
                    "Cannot reserve {$quantity} units of item {$itemId}"
                );
            });
    }

    public function updatePricing($itemId, $newPrice)
    {
        return Item::query()->where('id', $itemId)
            ->where('status', 'active')
            ->existsOr(function () use ($itemId) {
                event(new PricingUpdateFailed($itemId));

                return to_route('')
                    ->with('error', 'Item not found or inactive');
            });
    }
}
