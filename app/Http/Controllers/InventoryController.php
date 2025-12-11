<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\PricingUpdateFailed;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\ResourceNotFoundException;
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
                Log::warning('Stock check attempted for unavailable item: ' . $itemCode);

                return new JsonResponse([
                    'in_stock' => false,
                    'message'  => 'Item unavailable or out of stock',
                ], 404);
            });
    }

    public function reserveItem($itemId, $quantity): bool
    {
        $item = Item::query()->whereKey($itemId)->first();

        throw_unless($item, ResourceNotFoundException::class, resourceName: 'Item', context: ['item_id' => $itemId]);

        if ($item->available_quantity < $quantity)
        {
            throw new InsufficientStockException(
                message: sprintf('Cannot reserve %s units of item %s', $quantity, $itemId),
                context: [
                    'item_id'   => $itemId,
                    'requested' => $quantity,
                    'available' => $item->available_quantity,
                ]
            );
        }

        return true;
    }

    public function updatePricing($itemId, $newPrice)
    {
        return Item::query()->whereKey($itemId)
            ->where('status', 'active')
            ->existsOr(function () use ($itemId) {
                event(new PricingUpdateFailed($itemId));

                return to_route('')
                    ->with('error', 'Item not found or inactive');
            });
    }
}
