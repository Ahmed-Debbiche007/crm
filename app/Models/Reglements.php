<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglements extends Model
{
    use HasFactory;
    public function abonnement()
    {
        return $this->belongsTo(Abonnements::class);
    }
    protected $fillable = [
        'amount',
        'date',
        'abonnements_id'
    ];
}
