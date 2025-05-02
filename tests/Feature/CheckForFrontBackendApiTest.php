<?php

use Illuminate\Support\Fluent;

it('can get backend url details from front api', function () {

    Http::record();

    $result = Http::get(config('app.frontend_url').'/api/backend')->json();

    $result = Fluent::make($result);

    expect($result->data['backend_url'])->toBeUrl();

    $apiCallCount             = 0;
    $allStatusCodesSuccessful = true;

    Http::recorded(static function ($request, $response) use (&$apiCallCount, &$allStatusCodesSuccessful) {
        $apiCallCount++;

        // Check response status
        if ($response->status() >= 400) {
            $allStatusCodesSuccessful = false;
        }

        // Log the interaction for debugging
        Log::debug('API Call', [
            'url'    => $request->url(),
            'method' => $request->method(),
            'status' => $response->status(),
        ]);
    });

    $this->assertGreaterThan(0, $apiCallCount, 'No API calls were made');
    $this->assertTrue($allStatusCodesSuccessful, 'Some API calls failed');
});
