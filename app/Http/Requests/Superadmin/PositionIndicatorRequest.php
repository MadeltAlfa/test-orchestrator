<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class PositionIndicatorRequest extends FormRequest
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
        $rules = [
            'weight' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ];

        // indicator_id is required during store, but can be optional during direct update of a pivot record
        if ($this->isMethod('POST')) {
            $rules['indicator_id'] = [
                'required',
                'uuid',
                'exists:indicators,id',
            ];
            $rules['position_id'] = [
                'required',
                'uuid',
                'exists:positions,id',
            ];
        }

        return $rules;
    }

    /**
     * Custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'position_id' => 'Posisi',
            'indicator_id' => 'Indikator',
            'weight' => 'Bobot',
        ];
    }
}
