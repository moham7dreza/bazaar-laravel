<?php

declare(strict_types=1);

use App\Enums\OrderState;
use App\States\Order\Handler\OrderContext;

it('can change order states', function (): void {

    $this->sut = new OrderContext();

    expect($this->sut->getState())->toBe(OrderState::PENDING);

    $this->sut->proceedToNext();
    $this->sut->proceedToNext();
    $this->sut->proceedToNext();

    expect($this->sut->getState())->toBe(OrderState::SHIPPED);
});
