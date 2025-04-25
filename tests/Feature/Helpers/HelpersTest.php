<?php

it('can get memoized cache value', function () {

    /*
     * When you memoize a value, it is stored in memory for the duration of the request.
     * This means that if you change the value in the cache store, it will not affect the memoized value.
     * */

    cache()->put('foo', 'bar');

    expect(cache()->memo()->get('foo'))->toBe('bar');

    cache()->put('foo', 'bar222');

    expect(cache()->memo()->get('foo'))->toBe('bar');

    cache()->driver('database')->put('foo', 'bar111');

    expect(cache()->memo()->get('foo'))->toBe('bar')
        ->and(cache()->memo('database')->get('foo'))->toBe('bar111');
});
