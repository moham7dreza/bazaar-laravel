<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Uri;

it('can make uri with options', function (): void {

    $uri = Uri::of('https://example.com')
        ->withScheme('http')
        ->withHost('test.com')
        ->withPort(8000)
        ->withPath('/users')
        ->withQuery(['page' => 2])
        ->withFragment('section-1');

    expect($uri->value())->toBe('http://test.com:8000/users?page=2#section-1');
});

it('can easily handle plural of english word', function (): void {

    $commentsCount = 1;
    $comment       = str('comment')->plural($commentsCount);

    expect($comment->value())->toBe('comment');

    $commentsCount = 10;
    $comment       = str('comment')->plural($commentsCount);

    expect($comment->value())->toBe('comments');
});

it('can use fluent and collect to process data', function (): void {
    $data = [
        'user' => [
            'name'    => 'admin',
            'address' => [
                'city'    => 'urmia',
                'country' => 'iran',
            ],
        ],
        'posts' => [
            ['title' => 'post 1'],
            ['title' => 'post 2'],
        ],
    ];

    /*
     * من توی پروژه‌های اخیرم دیدم که Fluent با lazy loading می‌تونه برای کوئری‌های کوچک و روابط پیچیده خیلی بهینه باشه
     *  و کد رو خواناتر کنه. ولی برای داده‌های خیلی بزرگ یا پردازش‌های سنگین،
     *  Collection معمولاً بازدهی بهتری داره، چون متدهای مثل chunk() یا lazy() رو می‌تونم راحت‌تر کنترل کنم.
     * **/

    // Collection -> good to process data lists
    $userName    = collect($data)->get('user')['name'];
    $postTitles  = array_column(collect($data)->get('posts'), 'title');
    $addressJson = json_encode(collect($data)->get('user')['address'], JSON_THROW_ON_ERROR);

    expect($userName)->toBe('admin')
        ->and($postTitles)->toBe(['post 1', 'post 2'])
        ->and($addressJson)->toBe('{"city":"urmia","country":"iran"}');

    $addressCollectionFromJson = Collection::fromJson($addressJson);

    expect($addressCollectionFromJson->get('city'))->toBe('urmia');

    // Fluent -> good to fast access to data
    $user        = fluent($data)->user;
    $city        = fluent($data)->get('user.address.city');
    $postTitles  = fluent($data)->collect('posts')->pluck('title')->toArray();
    $addressJson = fluent($data)->scope('user.address')->toJson();

    expect($user)->toBe([
        'name'    => 'admin',
        'address' => [
            'city'    => 'urmia',
            'country' => 'iran',
        ],
    ])
        ->and($city)->toBe('urmia')
        ->and($postTitles)->toBe(['post 1', 'post 2'])
        ->and($addressJson)->toBe('{"city":"urmia","country":"iran"}');
});

it('can get path segments', function (): void {
    $uri = Uri::of('https://laravel.com/docs/12.x/validation');

    $segments      = $uri->pathSegments();
    $firstSegment  = $segments->first();
    $lastSegment   = $segments->last();
    $secondSegment = $segments->get(1);

    expect($firstSegment)->toBe('docs')
        ->and($secondSegment)->toBe('12.x')
        ->and($lastSegment)->toBe('validation');
});

it('can get solo item from array', function (): void {

    $employees = [
        ['id' => 1, 'name' => 'Sarah', 'department' => 'Engineering'],
        ['id' => 2, 'name' => 'Mike', 'department' => 'Marketing'],
        ['id' => 3, 'name' => 'Alex', 'department' => 'Sales'],
    ];

    // Get the sole engineering employee
    $engineer = Arr::sole($employees, static fn ($employee) => 'Engineering' === $employee['department']);

    expect($engineer)->toBe($employees[0]);
});
