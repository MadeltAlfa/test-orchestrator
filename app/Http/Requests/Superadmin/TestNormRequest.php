<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class TestNormRequest extends FormRequest
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
            'test_id' => [
                'required',
                'uuid',
                'exists:tests,id',
            ],
            'category' => [
                'required',
                'string',
                'in:Sangat Baik,Baik,Cukup,Sedang,Kurang,Sangat Kurang',
            ],
            'operator' => [
                'required',
                'string',
                'in:between,less_than,greater_than,less_equal,greater_equal',
            ],
            'min_value' => [
                'required_if:operator,between,greater_than,greater_equal',
                'nullable',
                'numeric',
            ],
            'max_value' => [
                'required_if:operator,between,less_than,less_equal',
                'nullable',
                'numeric',
            ],
            'score' => [
                'required',
                'integer',
                'min:0',
                'max:10', // Assuming a standard scale of 0-10 based on earlier service logic
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
            'test_id' => 'Tes Keahlian',
            'category' => 'Kategori Norma',
            'operator' => 'Operator',
            'min_value' => 'Nilai Minimal',
            'max_value' => 'Nilai Maksimal',
            'score' => 'Skor Normalisasi',
        ];
    }
}
