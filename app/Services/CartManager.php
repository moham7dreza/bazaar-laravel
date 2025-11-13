<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final readonly class CartManager
{
    private Collection $items;

    public function __construct(array $cartItems)
    {
        $this->items = collect($cartItems);
    }

    public function removeItems(string|array $productIds): self
    {
        $this->items->forget($productIds);

        return $this;
    }

    public function removeUnavailableProducts(array $outOfStock): self
    {
        $this->items
            ->forget(
                collect($outOfStock)
                    ->map(fn ($sku) => "product_{$sku}")
                    ->all()
            );

        return $this;
    }
}
