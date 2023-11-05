<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etage extends Model
{
    use HasFactory;

    public function appart()
    {
        return $this->hasMany(Appart::class);
    }

    public function building()
    {
        return $this->belongsTo(Residence::class, 'residence_id');
    }

   




    protected $fillable = [
        'name',
        'plan',
        'residence_id',
        'number',
    ];
}
