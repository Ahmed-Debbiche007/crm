<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    public function appart()
    {
        return $this->belongsTo(Appart::class);
    }


    protected $fillable = [
        'path',
        'residence_id',
        'appart_id'

    ];
}
