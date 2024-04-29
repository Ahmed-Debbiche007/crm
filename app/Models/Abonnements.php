<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnements extends Model
{
    use HasFactory;
    public function appart()
    {
        return $this->belongsTo(Appart::class);
    }
    public function reglements()
    {
        return $this->hasMany(Reglements::class);
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }

    protected $fillable = [
        'amount',
        'date',
        'appart_id',
        'annee'
    ];
}
