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

it('can easily handle plural of english word', function () {

    $commentsCount = 1;
    $comment = str('comment')->plural($commentsCount);

    expect($comment->value())->toBe('comment');

    $commentsCount = 10;
    $comment = str('comment')->plural($commentsCount);

    expect($comment->value())->toBe('comments');
});
