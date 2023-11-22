<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use HasFactory;

    public function etage()
    {
        return $this->hasMany(Etage::class);
    }

    public function parking()
    {
        return $this->hasMany(Parking::class);
    }

    public function cellier()
    {
        return $this->hasMany(Cellier::class);
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    protected $fillable = [
        'name',
        'address',
        'nfoncier',
        'emplacemnt',
        'npermis',
        'detailMunicipal',
        'detail',

    ];
}
