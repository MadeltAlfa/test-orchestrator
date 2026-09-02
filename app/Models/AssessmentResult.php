<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssessmentResult extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'assessment_id',
        'position_id',
        'score',
        'ranking',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'ranking' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Assessment induk
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Posisi hasil ranking
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Format score
     * contoh: 88.50
     */
    public function getFormattedScoreAttribute()
    {
        return number_format($this->score, 2);
    }

    /**
     * Label ranking
     */
    public function getRankingLabelAttribute()
    {
        return match ($this->ranking) {
            1 => 'Posisi Terbaik',
            2 => 'Alternatif Kedua',
            3 => 'Alternatif Ketiga',
            default => 'Alternatif',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah posisi terbaik
     */
    public function isBestPosition()
    {
        return $this->ranking === 1;
    }
}
