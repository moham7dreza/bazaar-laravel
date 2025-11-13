<?php

declare(strict_types=1);

namespace App\States\Order;

use App\Enums\OrderState;
use App\States\Order\Contracts\OrderStateInterface;
use App\States\Order\Handler\OrderContext;

class PendingState implements OrderStateInterface
{
    public function __toString(): string
    {
        return OrderState::Pending->value;
    }

    public function proceedToNext(OrderContext $context): void
    {
        $context->setState(new ProcessingState());
    }
}
