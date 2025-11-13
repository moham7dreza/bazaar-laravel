<?php

declare(strict_types=1);

namespace Modules\Payment\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class PaymentResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
