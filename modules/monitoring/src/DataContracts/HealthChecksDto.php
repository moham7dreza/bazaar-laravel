<?php

declare(strict_types=1);

namespace Modules\Monitoring\DataContracts;

final readonly class HealthChecksDto
{
    public function __construct(
        private string $name,
        private array $meta,
        private string $status,
        private string $notificationMessage,
        private string $shortSummary
    ) {
    }

    public function get(string|array $property): string|array|null
    {
        return $this->{$property} ?? null;
    }

    public function toArray(): array
    {
        return [
            'name'                => $this->name,
            'meta'                => $this->meta,
            'status'              => $this->status,
            'notificationMessage' => $this->notificationMessage,
            'shortSummary'        => $this->shortSummary,
        ];
    }
}
