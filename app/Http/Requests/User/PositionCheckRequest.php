<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PositionCheckRequest extends FormRequest
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
            'player_id' => [
                'nullable',
                'exists:players,id',
            ],
            'new_player_name' => [
                'nullable',
                'string',
                'max:255',
                'required_without:player_id',
            ],
            'new_player_dob' => [
                'nullable',
                'date',
                'required_without:player_id',
            ],
            'results' => [
                'required',
                'array',
                'min:1',
            ],
            'results.*' => [
                'required',
                'numeric',
                'min:0',
            ],
            'assessment_date' => [
                'nullable',
                'date',
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
            'results' => 'Hasil Tes',
            'results.*' => 'Nilai Hasil Tes',
            'assessment_date' => 'Tanggal Penilaian',
        ];
    }
}
