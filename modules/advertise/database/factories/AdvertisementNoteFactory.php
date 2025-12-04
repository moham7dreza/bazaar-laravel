<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;

/**
 * @extends Factory<AdvertisementNote>
 */
final class AdvertisementNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'advertisement_id' => Advertisement::factory(),
            'note'             => persian_faker()->text(),
        ];
    }
}
