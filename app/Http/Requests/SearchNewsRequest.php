<?php

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use App\Enums\SourceEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchNewsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string'],
            'date_from' => ['required_with:date_to', 'date'],
            'date_to' => ['required_with:date_from', 'date'],
            'category' => ['nullable', Rule::in(CategoryEnum::values())],
            'source' => ['nullable', Rule::in(SourceEnum::values())]
        ];
    }
}
