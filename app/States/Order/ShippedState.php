<?php

namespace App\States\Order;

use App\Enums\OrderState;
use App\States\Order\Contracts\OrderStateInterface;
use App\States\Order\Handler\OrderContext;

class ShippedState implements OrderStateInterface
{
    public function proceedToNext(OrderContext $context): void
    {
//        logger("⚠️ Order already shipped! Cannot proceed further.\n");
    }

    public function __toString(): string
    {
        return OrderState::SHIPPED->value;
    }
}
