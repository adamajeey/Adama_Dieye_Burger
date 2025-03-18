<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommandeConfirmation extends Notification
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
            ->subject('Confirmation de votre commande #' . $this->commande->numCommande)
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ',')
            ->line('Merci d\'avoir passé commande sur ISI Burger.')
            ->line('Votre commande #' . $this->commande->numCommande . ' a été reçue et est en cours de traitement.')
            ->line('Montant total : ' . number_format($total, 0, ',', ' ') . ' F CFA')
            ->action('Voir ma commande', url('/commandes/' . $this->commande->id))
            ->line('Nous vous informerons lorsque votre commande sera prête.');
    }
}
