<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

final class BusinessRuleValidator
{
    public function validateTeamStructure(Collection $members)
    {
        // Ensure exactly one team lead exists
        if ( ! $members->containsOneItem(fn ($member) => 'lead' === $member->role))
        {
            throw new ValidationException('Exactly one team lead required');
        }

        // Ensure exactly one budget approver
        if ( ! $members->containsOneItem(fn ($member) => $member->can_approve_budget))
        {
            throw new ValidationException('Exactly one budget approver required');
        }

        return true;
    }

    public function validateInvoiceItems(Collection $items)
    {
        $validations = [
            'handling'   => $items->containsOneItem(fn ($item) => 'handling' === $item->type),
            'processing' => $items->containsOneItem(fn ($item) => 'processing' === $item->type),
            'delivery'   => $items->containsOneItem(fn ($item) => 'delivery' === $item->type),
        ];

        foreach ($validations as $type => $isValid)
        {
            if ( ! $isValid)
            {
                throw new ValidationException("Exactly one {$type} fee required");
            }
        }

        return $items;
    }
}
