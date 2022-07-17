<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'profile_image',
        'headline',
        'skill_summary',
        'currency_id',
        'hourly_rate',
        'status'
    ];

    public function getCurrency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }     
}
