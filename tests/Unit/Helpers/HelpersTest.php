<?php

use Illuminate\Support\Uri;

it('can make uri with options', function () {

    $uri = Uri::of('https://example.com')
        ->withScheme('http')
        ->withHost('test.com')
        ->withPort(8000)
        ->withPath('/users')
        ->withQuery(['page' => 2])
        ->withFragment('section-1');

    expect($uri->value())->toBe('http://test.com:8000/users?page=2#section-1');
});
