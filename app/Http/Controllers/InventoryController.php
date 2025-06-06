<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\PricingUpdateFailed;
use App\Exceptions\InsufficientStockException;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function verifyStock($itemCode)
    {
        return Item::where('code', $itemCode)
            ->where('quantity', '>', 0)
            ->existsOr(function () use ($itemCode) {
                Log::warning("Stock check attempted for unavailable item: {$itemCode}");

                return response()->json([
                    'in_stock' => false,
                    'message'  => 'Item unavailable or out of stock',
                ], 404);
            });
    }

    public function reserveItem($itemId, $quantity)
    {
        return Item::where('id', $itemId)
            ->where('available_quantity', '>=', $quantity)
            ->existsOr(function () use ($itemId, $quantity): void {
                throw new InsufficientStockException(
                    "Cannot reserve {$quantity} units of item {$itemId}"
                );
            });
    }

    public function updatePricing($itemId, $newPrice)
    {
        return Item::where('id', $itemId)
            ->where('status', 'active')
            ->existsOr(function () use ($itemId) {
                event(new PricingUpdateFailed($itemId));

                return redirect()
                    ->route('inventory.index')
                    ->with('error', 'Item not found or inactive');
            });
    }
}
