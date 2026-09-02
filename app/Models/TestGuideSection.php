<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TestGuideSection extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'test_guide_id',
        'section_title',
        'content',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Guide induk
     */
    public function guide()
    {
        return $this->belongsTo(
            TestGuide::class,
            'test_guide_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Preview content pendek
     */
    public function getShortContentAttribute()
    {
        return \Illuminate\Support\Str::limit(
            strip_tags($this->content),
            120
        );
    }

    /**
     * Nomor urutan section
     */
    public function getFormattedOrderAttribute()
    {
        return 'Section ' . $this->sort_order;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah section pertama
     */
    public function isFirst()
    {
        return $this->sort_order === 1;
    }

    /**
     * Cek apakah section memiliki content
     */
    public function hasContent()
    {
        return !empty(trim(strip_tags($this->content)));
    }
}
