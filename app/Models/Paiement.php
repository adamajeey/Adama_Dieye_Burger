<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use SoftDeletes;
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
