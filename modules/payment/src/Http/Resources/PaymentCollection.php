<?php

declare(strict_types=1);

namespace Modules\Payment\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

class PaymentCollection extends ResourceCollection
{
    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
