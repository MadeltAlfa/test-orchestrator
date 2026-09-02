<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class SkillTestRequest extends FormRequest
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
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'input_type' => [
                'required',
                'string',
                'in:time,number',
            ],
            'unit' => [
                'required',
                'string',
                'max:20',
            ],
            'use_stopwatch' => [
                'nullable',
                'boolean',
            ],
            'use_increment' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'use_stopwatch' => $this->boolean('use_stopwatch'),
            'use_increment' => $this->boolean('use_increment'),
        ]);
    }

    /**
     * Custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Tes',
            'description' => 'Deskripsi',
            'input_type' => 'Tipe Input',
            'unit' => 'Satuan',
            'use_stopwatch' => 'Gunakan Stopwatch',
            'use_increment' => 'Gunakan Increment',
        ];
    }
}
