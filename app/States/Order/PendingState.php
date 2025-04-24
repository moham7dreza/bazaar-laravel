<?php

namespace App\States\Order;

use App\Enums\OrderState;
use App\States\Order\Contracts\OrderStateInterface;
use App\States\Order\Handler\OrderContext;

class PendingState implements OrderStateInterface
{
    public function proceedToNext(OrderContext $context): void
    {
        $context->setState(new ProcessingState());
    }

    public function __toString(): string
    {
        return OrderState::PENDING->value;
    }
}
