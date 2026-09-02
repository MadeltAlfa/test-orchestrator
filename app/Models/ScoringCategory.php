<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ScoringCategory extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'min_score',
        'max_score',
    ];

    protected $casts = [
        'min_score' => 'integer',
        'max_score' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Range score
     * contoh:
     * 9 - 10
     */
    public function getScoreRangeAttribute()
    {
        return $this->min_score . ' - ' . $this->max_score;
    }

    /**
     * Badge color bootstrap
     */
    public function getBadgeColorAttribute()
    {
        return match ($this->name) {
            'Sangat Baik' => 'success',
            'Baik' => 'primary',
            'Sedang' => 'warning',
            'Cukup' => 'warning',
            'Kurang' => 'danger',
            default => 'dark',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah score termasuk kategori ini
     */
    public function containsScore($score)
    {
        return $score >= $this->min_score
            && $score <= $this->max_score;
    }

    /**
     * Ambil kategori berdasarkan score
     */
    public static function findByScore($score)
    {
        return self::where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->first();
    }
}
