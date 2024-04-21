<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public function appartements()
    {
        return $this->hasMany(Appart::class);
    }

    public function echances()
    {
        return $this->hasMany(Echance::class);
    }


    protected $fillable = [
        'name',
        'lastName',
        'phone',
        'cin',
        'email',
        'type',
        'comments',
        'date_res'
    ];
}
