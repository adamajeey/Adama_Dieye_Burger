<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Commande extends Model
{
    use SoftDeletes, HasRoles, HasPermissions;

    protected $table = 'commandes';
    protected $fillable = [
        'numCommande',
        'statut'
    ];

    public function burgers()
    {
        return $this->hasMany(Burger::class);
    }

    public function details()
    {
        return $this->hasMany(Commande_detail::class, 'commande_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'commande_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
