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

    public function client(){
        return $this->belongsTo(Client::class);
    }
    protected $fillable = [
        'client_id',
        'sonede',
        'syndic',
        'avocat',
        'contrat',
        'foncier',
        'appart_id'
    ];
}
