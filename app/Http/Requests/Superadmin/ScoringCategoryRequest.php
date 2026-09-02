<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class ScoringCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'min_score' => [
                'required',
                'integer',
                'min:0',
            ],
            'max_score' => [
                'required',
                'integer',
                'min:0',
                'gte:min_score',
            ],
        ];
    }

    /**
     * Custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Kategori',
            'min_score' => 'Nilai Minimal',
            'max_score' => 'Nilai Maksimal',
        ];
    }
}
