<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturePrete extends Notification
{
    use Queueable;

    protected $commande;
    protected $pdfPath;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
        $this->genererPDF();
    }

    protected function genererPDF()
    {
        $pdf = PDF::loadView('factures.facture', ['commande' => $this->commande]);
        $filename = 'facture-' . $this->commande->numCommande . '.pdf';

        // Créer le répertoire s'il n'existe pas
        if (!file_exists(storage_path('app/public/factures'))) {
            mkdir(storage_path('app/public/factures'), 0755, true);
        }

        $path = storage_path('app/public/factures/' . $filename);
        $pdf->save($path);
        $this->pdfPath = $path;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre commande #' . $this->commande->numCommande . ' est prête')
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ',')
            ->line('Nous sommes heureux de vous informer que votre commande est prête.')
            ->line('Vous trouverez ci-joint votre facture.')
            ->line('Vous pouvez venir récupérer votre commande dès maintenant.')
            ->action('Voir ma commande', url('/commandes/' . $this->commande->id))
            ->line('Merci d\'avoir choisi ISI BURGER!')
            ->attach($this->pdfPath, [
                'as' => 'facture-' . $this->commande->numCommande . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
