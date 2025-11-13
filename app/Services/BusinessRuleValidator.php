<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

final class BusinessRuleValidator
{
    public function validateTeamStructure(Collection $members): bool
    {
        // Ensure exactly one team lead exists
        throw_unless($members->containsOneItem(fn ($member): bool => 'lead' === $member->role), ValidationException::class, 'Exactly one team lead required');

        // Ensure exactly one budget approver
        throw_unless($members->containsOneItem(fn ($member) => $member->can_approve_budget), ValidationException::class, 'Exactly one budget approver required');

        return true;
    }

    public function validateInvoiceItems(Collection $items)
    {
        $validations = [
            'handling'   => $items->containsOneItem(fn ($item): bool => 'handling' === $item->type),
            'processing' => $items->containsOneItem(fn ($item): bool => 'processing' === $item->type),
            'delivery'   => $items->containsOneItem(fn ($item): bool => 'delivery' === $item->type),
        ];

        foreach ($validations as $type => $isValid)
        {
            throw_unless($isValid, ValidationException::class, sprintf('Exactly one %s fee required', $type));
        }

        return $items;
    }
}
