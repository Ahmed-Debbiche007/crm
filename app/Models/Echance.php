<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echance extends Model
{
    use HasFactory;

    public function appart()
    {
        return $this->belongsTo(Appart::class);
    }


    protected $fillable = [
        'appart_id',
        'type',
        'date',
        'amount',
        'date_avance',
        'amount_avance',
        'payed',
        'preuve_avance',
        'promesse',
        'contrat'
    ];
}
