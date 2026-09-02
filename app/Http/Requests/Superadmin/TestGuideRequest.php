<?php

declare(strict_types=1);

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class TestGuideRequest extends FormRequest
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
        $guideId = $this->route('testGuide')?->id ?? $this->route('testGuide');

        return [
            'test_id' => [
                'required',
                'uuid',
                'exists:tests,id',
                'unique:test_guides,test_id,' . $guideId,
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:2000',
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:10240', // max 10MB (mendukung animasi GIF)
            ],
            'video_url' => [
                'nullable',
                'url',
                'max:255',
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
            'title' => 'Judul Panduan',
            'description' => 'Deskripsi Panduan',
            'image' => 'Gambar Panduan',
            'video_url' => 'URL Video Tutorial',
        ];
    }
}
