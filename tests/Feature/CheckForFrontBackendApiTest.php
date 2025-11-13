<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;
use Tests\TestGroup;

use function Pest\Laravel\assertGreaterThan;
use function Pest\Laravel\assertTrue;

pest()->group(TestGroup::MANUAL);

it('can get backend url details from front api', function (): void {

    Http::record();

    $result = Http::get(config('app.frontend_url') . '/api/backend')->json();

    $result = Fluent::make($result);

    expect(Arr::get($result->data, 'backend_url'))->toBeUrl();

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

    assertGreaterThan(0, $apiCallCount, 'No API calls were made');
    assertTrue($allStatusCodesSuccessful, 'Some API calls failed');
});
