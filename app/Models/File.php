<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    protected $fillable = [
        'path',
        'residence_id',
        'name'
    ];
}