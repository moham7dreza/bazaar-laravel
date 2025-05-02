<?php

namespace App\Console\Commands\Advertisement;

use App\Models\Advertise\Advertisement;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class AdvertisementLadderCommand extends Command implements PromptsForMissingInput
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
        $date = Carbon::parse($this->argument('date'));

        Advertisement::query()
            ->where('published_at', '<=', $date)
            ->update(['is_ladder' => true]);

        return self::SUCCESS;
    }
}
