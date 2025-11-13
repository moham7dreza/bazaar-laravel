<?php

declare(strict_types=1);

namespace App\States\Order\Contracts;

use App\States\Order\Handler\OrderContext;

interface OrderStateInterface
{
    public function __toString(): string;

    public function proceedToNext(OrderContext $context);
}
