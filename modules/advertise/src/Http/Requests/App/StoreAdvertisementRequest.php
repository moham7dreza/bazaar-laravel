<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\App;

use Cknow\Money\Rules\Money;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Advertise\Enums\AdvertisementStatus;
use Modules\Advertise\Enums\AdvertisementType;

final class StoreAdvertisementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            => ['required', 'max:120', 'min:2', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u'],
            'description'      => ['required', 'max:700', 'min:2'],
            'ads_type'         => [
                'nullable',
                'max:120',
                'min:2',
                'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                Rule::enum(AdvertisementType::class),
            ],
            'ads_status'       => [
                'required',
                'max:120',
                'min:2',
                'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,_ ]+$/u',
                Rule::enum(AdvertisementStatus::class),
            ],
            'category_id'      => ['required', 'min:1', 'max:100000000', 'regex:/^[0-9]+$/u', 'exists:categories,id'],
            'city_id'          => ['required', 'min:1', 'max:100000000', 'regex:/^[0-9]+$/u', 'exists:cities,id'],
            'contact'          => ['nullable', 'max:255', 'min:2'],
            'image'            => ['nullable', 'max:2000', 'image', 'mimes:png,jpg,jpeg,gif'],
            'price'            => ['nullable', new Money()],
            'tags'             => ['nullable'],
            'lng'              => ['nullable', 'numeric'],
            'lat'              => ['nullable', 'numeric'],
            'willing_to_trade' => ['nullable', 'numeric', 'in:0,1'],
            // relations
            'category_values'   => ['nullable', 'array'],
            'category_values.*' => ['exists:category_values,id'],
        ];
    }
}
