<?php

namespace App\States\Order\Handler;

use App\Enums\OrderState;
use App\States\Order\Contracts\OrderStateInterface;
use App\States\Order\PendingState;

class OrderContext
{
    private OrderStateInterface $state;

    public function __construct()
    {
        $this->state = new PendingState(); // وضعیت اولیه
    }

    public function setState(OrderStateInterface $state): void
    {
        $this->state = $state;
    }

    public function getState(): OrderState
    {
        return OrderState::from((string) $this->state);
    }

    public function proceedToNext(): void
    {
        $this->state->proceedToNext($this);
    }

    public function __toString(): string
    {
        return $this->getState()->value;
    }
}
