<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Burger extends Model
{
    use SoftDeletes, HasRoles, HasPermissions;
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
