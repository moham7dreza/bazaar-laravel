<?php

declare(strict_types=1);

namespace App\Services;

final readonly class NotificationService
{
    public function sendEmails($recipients, $message)
    {
        return Collection::wrap($recipients)
            ->map(fn ($email) => $this->validateEmail($email))
            ->filter()
            ->each(fn ($email) => $this->dispatch($email, $message));
    }

    public function assignCategories($ad, $categories)
    {
        $currentCategories = $ad->categories;
        $newCategories     = Collection::wrap($categories)
            ->unique()
            ->diff($currentCategories);

        $ad->categories()->sync($newCategories);

        return $ad;
    }

    public function formatNotifications($notifications)
    {
        return Collection::wrap($notifications)
            ->map(fn ($notification) => [
                'id'        => $notification->id,
                'message'   => $notification->content,
                'timestamp' => $notification->created_at,
            ])
            ->sortByDesc('timestamp');
    }
}
