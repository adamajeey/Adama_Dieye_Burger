<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Burger extends Model
{
    use SoftDeletes;
    protected $table = 'burgers';
    protected $fillable =
        [
            'libelle',
            'prix',
            'image',
            'description',
            'stock',
        ];

    public function commandes()
    {
        return $this->belongsToMany('App\Models\Commande', 'commande_details', 'burger_id', 'commande_id');
    }
}
