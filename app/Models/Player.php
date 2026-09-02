<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Player extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'coach_id',
        'name',
        'dob',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }
}
