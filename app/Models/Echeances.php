<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeances extends Model
{
    use HasFactory;

    public function echance()
    {
        return $this->belongsTo(Echance::class);
    }

    protected $fillable = [
        'echance_id',
        'date',
        'montant',
        'payed',
        'modalite'
    ];
}
