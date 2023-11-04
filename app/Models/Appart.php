<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appart extends Model
{
    use HasFactory;

    public function etage()
    {
        return $this->belongsTo(Etage::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    

    protected $fillable = [
        'name',
        'etage_id',
        'type',
        'surface',
        'price',
        'bs',
        'comments',

    ];
}
