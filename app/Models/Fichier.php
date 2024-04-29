<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
    use HasFactory;

    public function abonnement()
    {
        return $this->belongsTo(Abonnements::class, 'abonnement_id');
    }

    protected $fillable = [
        'name',
        'path',
        'abonnements_id'
    ];
}