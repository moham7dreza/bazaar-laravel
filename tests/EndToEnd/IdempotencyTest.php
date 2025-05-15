<?php

declare(strict_types=1);

it('can not apply multiple requests', function (): void {

    $response = $this->postJson(route('idempotency'))
        ->withHeaders([
            App\Enums\RequestHeader::IDEMPOTENCY_KEY->value => '123e4567-e89b-12d3-a456-426614174000',
        ]);
    dd($response->content());
});
