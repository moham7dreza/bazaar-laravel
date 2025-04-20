<?php

namespace App\Http\Controllers;

use App\Dtos\HealthChecksDto;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Result;
use Spatie\Health\Health;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\CacheCheck;

class HealthCheckController extends Controller
{

    public function __construct(
        private readonly Health $healthChecker,
    )
    {
    }

    public function check(): JsonResponse
    {
        $this->registerChecks();

        return ApiJsonResponse::success(
            array_map(function ($check) {
                return $this->newHealthStatusDto($check->run(), $check->getName())->toArray();
            }, $this->healthChecker->registeredChecks()->toArray())
        );
    }

    private function registerChecks(): void
    {
        $this->healthChecker->checks(array_merge(
            [
                EnvironmentCheck::new()->expectEnvironment(getenv('APP_ENV')),
                UsedDiskSpaceCheck::new()
                    ->warnWhenUsedSpaceIsAbovePercentage(70)
                    ->failWhenUsedSpaceIsAbovePercentage(90),
                CpuLoadCheck::new()
                    ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                    ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            ],
            $this->registerGetPingChecks(),
            $this->registerPostPingChecks(),
            [
                DatabaseCheck::new()->connectionName(getenv('DB_CONNECTION')),
                CacheCheck::new()->driver('redis'),
            ]
        ));
    }

    private function registerGetPingChecks(): array
    {
        $getEndpoints = [
            '/api/categories',
            '/api/menus',
            '/api/pages',
            '/api/advertisements',
            '/api/states',
            '/api/cities',
        ];

        return $this->registerPingCheck($getEndpoints, 'GET');
    }

    private function registerPostPingChecks(): array
    {
        $postEndpoints = [];

        return $this->registerPingCheck($postEndpoints, 'POST');
    }

    private function registerPingCheck(array $urls, string $method): array
    {
        return array_map(static function ($url) use ($method) {
            $basePath = getenv('APP_URL');
            return PingCheck::new()
                ->url($basePath . $url)
                ->name($url)
                ->method($method);
        }, $urls);
    }

    private function newHealthStatusDto(Result $healthStatusResult, string $checkName): HealthChecksDto
    {
        return new HealthChecksDto(
            $checkName,
            $healthStatusResult->meta,
            $healthStatusResult->status->value,
            $healthStatusResult->notificationMessage,
            $healthStatusResult->shortSummary
        );
    }
}
