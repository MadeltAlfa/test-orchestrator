<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class TestGuideSectionRequest extends FormRequest
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
            'test_guide_id' => [
                'required',
                'uuid',
                'exists:test_guides,id',
            ],
            'section_title' => [
                'required',
                'string',
                'max:255',
            ],
            'content' => [
                'required',
                'string',
                'max:5000',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:1',
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
            'test_guide_id' => 'Panduan Tes',
            'section_title' => 'Judul Bagian',
            'content' => 'Konten / Detail',
            'sort_order' => 'Urutan Tampil',
        ];
    }
}
