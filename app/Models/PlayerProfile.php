<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PlayerProfile extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'age',
        'height',
        'weight',
    ];

    protected $casts = [
        'age' => 'integer',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * User pemilik profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Gender label
     */
    public function getGenderLabelAttribute()
    {
        return match ($this->gender) {
            'L' => 'Laki-Laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    /**
     * Tinggi format
     * contoh: 172.50 cm
     */
    public function getFormattedHeightAttribute()
    {
        return number_format($this->height, 2) . ' cm';
    }

    /**
     * Berat format
     * contoh: 65.00 kg
     */
    public function getFormattedWeightAttribute()
    {
        return number_format($this->weight, 2) . ' kg';
    }

    /**
     * BMI pemain
     */
    public function getBmiAttribute()
    {
        if (!$this->height || !$this->weight) {
            return null;
        }

        $heightInMeter = $this->height / 100;

        return round(
            $this->weight / ($heightInMeter * $heightInMeter),
            2
        );
    }

    /**
     * Kategori BMI
     */
    public function getBmiCategoryAttribute()
    {
        $bmi = $this->bmi;

        if (!$bmi) {
            return '-';
        }

        return match (true) {
            $bmi < 18.5 => 'Kurus',
            $bmi < 25 => 'Normal',
            $bmi < 30 => 'Berlebih',
            default => 'Obesitas',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah profile lengkap
     */
    public function isComplete()
    {
        return !empty($this->full_name);
    }
}
