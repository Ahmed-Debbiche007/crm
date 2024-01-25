<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellier extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    public function etage()
    {
        return $this->belongsTo(Etage::class);
    }

    public function appart()
    {
        return $this->belongsTo(Appart::class);
    }


    protected $fillable = [
        'name',
        'client_id',
        'residence_id',
        'etage_id',
        'appart_id',

    ];
}
