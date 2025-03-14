<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Paiement extends Model
{
    use SoftDeletes, HasRoles, HasPermissions;
    protected $table = 'paiements';
    protected $fillable = [
        'url_pdf',
        'montant',
        'commande_id'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
