<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementGridViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['string']
        ];
    }
}
