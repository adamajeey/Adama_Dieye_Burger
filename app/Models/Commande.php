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
        'statut',
        'user_id'
    ];

    // Constantes pour les statuts
    const STATUT_EN_ATTENTE = 0;
    const STATUT_EN_PREPARATION = 1;
    const STATUT_EN_LIVRAISON = 2;
    const STATUT_PAYEE = 3;

    // Tableau pour l'affichage des statuts en texte
    public static $statutsTexte = [
        self::STATUT_EN_ATTENTE => 'En attente',
        self::STATUT_EN_PREPARATION => 'En préparation',
        self::STATUT_EN_LIVRAISON => 'En livraison',
        self::STATUT_PAYEE => 'Payée'
    ];

    // Méthode pour obtenir le libellé du statut
    public function getStatutTexte()
    {
        return self::$statutsTexte[$this->statut] ?? 'Inconnu';
    }

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
