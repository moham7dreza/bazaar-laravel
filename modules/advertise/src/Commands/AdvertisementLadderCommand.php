<?php

declare(strict_types=1);

namespace Modules\Advertise\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Date;
use Modules\Advertise\Models\Advertisement;

final class AdvertisementLadderCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advertisement:ladder {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ladder old advertisements';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $date = Date::parse($this->argument('date'));

        Advertisement::query()
            ->where('published_at', '<=', $date)
            ->update(['is_ladder' => true]);

        return self::SUCCESS;
    }
}
