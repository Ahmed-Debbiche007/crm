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

    public function image(){
        return $this->hasMany(Image::class);
    }

    public function charge(){
        return $this->hasMany(Charge::class);
    }

    public function echance(){
        return $this->hasMany(Echance::class);
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
