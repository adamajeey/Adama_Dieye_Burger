<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouvelleCommande extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $total = 0;
        foreach($this->commande->details as $detail) {
            $total += $detail->burger->prix * $detail->quantite;
        }

        return (new MailMessage)
            ->subject('Nouvelle commande #' . $this->commande->numCommande)
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ',')
            ->line('Une nouvelle commande a été passée.')
            ->line('Commande #: ' . $this->commande->numCommande)
            ->line('Client: ' . $this->commande->user->prenom . ' ' . $this->commande->user->nom)
            ->line('Montant: ' . number_format($total, 0, ',', ' ') . ' F CFA')
            ->action('Voir les détails', url('/commandes/' . $this->commande->id))
            ->line('Veuillez traiter cette commande dès que possible.');
    }
}
