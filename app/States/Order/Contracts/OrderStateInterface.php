<?php

namespace App\States\Order\Contracts;

use App\States\Order\Handler\OrderContext;

interface OrderStateInterface
{
    public function proceedToNext(OrderContext $context);
    public function __toString(): string;
}
