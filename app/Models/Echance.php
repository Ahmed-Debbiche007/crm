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

    public function echeance(){
        return $this->hasMany(Echeances::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    protected $fillable = [
        'id',
        'appart_id',
        'date',
        'client_id',
        'date_avance',
        'amount_avance',
        'preuve_avance',
        'promesse',
        'date_promesse_livre',
        'date_promesse_legal',
        'contrat',
        'date_contrat_livre',
        'date_contrat_enregistre',
        'price',
        'acte',
        'date_acte_livre',
        'date_acte_enreg',
    ];
}
