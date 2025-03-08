<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    use SoftDeletes;

    protected $table = 'commandes';
    protected $fillable = [
        'numCommande',
        'statut'
    ];

    public function burgers ()
    {
        return $this->hasMany(Burger::class);
    }

}
