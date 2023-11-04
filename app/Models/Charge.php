<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    public function appart()
    {
        return $this->belongsTo(Appart::class);
    }

    protected $fillable = [
        'sonede',
        'syndic',
        'avocat',
        'contrat',
        'foncier',
        'appart_id'
    ];
}
