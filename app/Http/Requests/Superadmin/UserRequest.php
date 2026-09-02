<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user')?->id ?? $this->route('user');

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $userId,
            ],
            'role' => [
                'required',
                'string',
                'in:user,superadmin',
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = [
                'required',
                'string',
                'min:8',
            ];
        } else {
            $rules['password'] = [
                'nullable',
                'string',
                'min:8',
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
            'name' => 'Nama Lengkap',
            'email' => 'Alamat Email',
            'password' => 'Kata Sandi',
        ];
    }
}
