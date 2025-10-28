<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Number;
use Illuminate\Support\Str;

final class NotificationFormatter
{
    public function formatInventoryAlert($product): string
    {
        return 'INVENTORY ALERT: Only ' . Number::spell(\Illuminate\Support\Arr::get($product, 'stock_remaining'), until: 5) .
            ' units of ' . \Illuminate\Support\Arr::get($product, 'name') . ' remain in stock. The minimum threshold is ' .
            Number::spell(\Illuminate\Support\Arr::get($product, 'min_threshold'), until: 5) . ' units.';
    }

    public function formatActivityUpdate($activity): string
    {
        $template = '**{user}** {action} in *{project}*';

        $message = strtr($template, [
            '{user}'    => $activity->user->name,
            '{action}'  => $activity->description,
            '{project}' => $activity->project->title,
        ]);

        return Str::inlineMarkdown($message, [
            'html_input'         => 'escape',
            'allow_unsafe_links' => false,
        ]);
    }

    public function formatSystemAlert(string $message, array $context = []): string
    {
        $processed = strtr($message, $context);

        return Str::inlineMarkdown($processed, [
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
            'use_autolinks'      => false, // Disable for security
        ]);
    }
}
