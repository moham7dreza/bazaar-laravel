<?php

declare(strict_types=1);

use Illuminate\Support\Fluent;
use Tests\TestGroup;

it('can get backend url details from front api', function (): void {

    Http::record();

    $result = Http::get(config('app.frontend_url') . '/api/backend')->json();

    $result = Fluent::make($result);

    expect($result->data['backend_url'])->toBeUrl();

    $apiCallCount             = 0;
    $allStatusCodesSuccessful = true;

    Http::recorded(static function ($request, $response) use (&$apiCallCount, &$allStatusCodesSuccessful): void {
        $apiCallCount++;

        // Check response status
        if ($response->status() >= 400)
        {
            $allStatusCodesSuccessful = false;
        }

        // Log the interaction for debugging
        Log::debug('API Call', [
            'url'    => $request->url(),
            'method' => $request->method(),
            'status' => $response->status(),
        ]);
    });

    Pest\Laravel\assertGreaterThan(0, $apiCallCount, 'No API calls were made');
    Pest\Laravel\assertTrue($allStatusCodesSuccessful, 'Some API calls failed');
})
    ->skip(TestGroup::MANUAL);
