<?php

namespace App\Http\Requests;


use App\Enums\CategoryEnum;
use App\Enums\SourceEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserNewsFeedPreferenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'category.*' => ['nullable', Rule::in(CategoryEnum::values())],
            'source.*' => ['nullable', Rule::in(SourceEnum::values())],
            'author.*' => ['nullable', 'string'],
        ];
    }
}
