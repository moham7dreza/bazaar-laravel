<?php

declare(strict_types=1);

namespace Modules\Monitoring\Commands;

use App\Notifications\VulnerabilitiesFoundNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use JsonException;

final class CheckVulnerabilitiesCommand extends Command
{
    protected $signature = 'security:check-vulnerabilities';

    protected $description = 'Check for vulnerabilities using Composer audit and send notification if found';

    /**
     * @throws JsonException
     */
    public function handle(): int
    {
        $vulnerabilities = Arr::get(json_decode(shell_exec('composer audit --format=json'), true, 512, JSON_THROW_ON_ERROR), 'advisories', []);

        if (count($vulnerabilities) > 0)
        {
            $text = 'Composer Audit: ' . count($vulnerabilities) . ' vulnerabilities found' . json_encode(array_keys($vulnerabilities), JSON_THROW_ON_ERROR);
        } else
        {
            $text = 'Composer Audit: No security vulnerability advisories found.';
        }

        admin()->notify(new VulnerabilitiesFoundNotification($text));

        $this->components->info($text);

        return static::SUCCESS;
    }
}
