<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Enums\Sort;

final class AdvertisementGridViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phrase'   => ['string'],
            'sort'     => [Rule::enum(Sort::class)],
            'per_page' => ['integer'],
            'ids'      => ['array', Rule::exists('advertisements', 'id')->whereNull('deleted_at')],
        ];
    }

    public function getDTO(): AdvertisementSearchDTO
    {
        return new AdvertisementSearchDTO(
            phrase: $this->str('phrase'),
            sort: $this->enum('sort', Sort::class),
            perPage: $this->integer('per_page', 24),
            ids: $this->array('ids'),
        );
    }
}
