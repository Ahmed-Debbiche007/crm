<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
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


    protected $fillable = [
        'name',
        'number',
        'client_id',
        'residence_id',

    ];
}
