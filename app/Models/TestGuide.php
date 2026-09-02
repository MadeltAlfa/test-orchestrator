<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TestGuide extends Model
{
     use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'test_id',
        'title',
        'description',
        'image',
        'video_url',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Tes terkait
     */
    public function test()
    {
        return $this->belongsTo(SkillTest::class, 'test_id');
    }

    /**
     * Section panduan
     */
    public function sections()
    {
        return $this->hasMany(
            TestGuideSection::class,
            'test_guide_id'
        )
        ->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * URL gambar guide
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png');
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Jumlah section
     */
    public function getTotalSectionsAttribute()
    {
        return $this->sections()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah punya gambar
     */
    public function hasImage()
    {
        return !empty($this->image);
    }

    /**
     * Cek apakah punya section
     */
    public function hasSections()
    {
        return $this->sections()->exists();
    }
}
