<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class PlayerProfileRequest extends FormRequest
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
            'full_name' => [
                'required',
                'string',
                'max:255',
            ],
            'gender' => [
                'required',
                'string',
                'in:L,P',
            ],
            'age' => [
                'required',
                'integer',
                'min:5',
                'max:100',
            ],
            'height' => [
                'required',
                'numeric',
                'min:50',
                'max:250',
            ],
            'weight' => [
                'required',
                'numeric',
                'min:10',
                'max:200',
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
            'full_name' => 'Nama Lengkap Pemain',
            'gender' => 'Jenis Kelamin',
            'age' => 'Umur',
            'height' => 'Tinggi Badan',
            'weight' => 'Berat Badan',
        ];
    }
}
