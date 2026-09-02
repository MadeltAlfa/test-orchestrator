<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class IndicatorRequest extends FormRequest
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
        $indicatorId = $this->route('indicator')?->id ?? $this->route('indicator');

        return [
            'code' => [
                'required',
                'string',
                'max:10',
                'unique:indicators,code,' . $indicatorId,
            ],
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'scoring_note' => [
                'nullable',
                'string',
                'max:1000',
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
            'code' => 'Kode Indikator',
            'name' => 'Nama Indikator',
            'description' => 'Deskripsi',
            'scoring_note' => 'Catatan Penilaian',
        ];
    }
}
