<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Commande_detail extends Model
{
    use SoftDeletes, HasRoles, HasPermissions;

    protected $table = 'commande_details';

    protected $fillable = [
        'commande_id',
        'burger_id',
        'quantite',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function burger()
    {
        return $this->belongsTo(Burger::class);
    }

    public function total()
    {
        return $this->quantite * $this->burger->prix;
    }


}
