<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Option 1: Attribuer le rôle de gestionnaire à un utilisateur spécifique par email
        $user = User::where('email', 'adamadieye780@gmail.com')->first();
        if ($user) {
            $user->role = 'gestionnaire';
            $user->save();
            $this->command->info('Rôle gestionnaire attribué à ' . $user->prenom . ' ' . $user->nom);
        } else {
            $this->command->warn('Utilisateur avec email adamadieye780@gmail.com non trouvé');
        }

        // Option 2: Attribuer le rôle de gestionnaire à un utilisateur spécifique par ID
        $user = User::find(1); // Remplacer par l'ID de l'utilisateur souhaité
        if ($user) {
            $user->role = 'gestionnaire';
            $user->save();
            $this->command->info('Rôle gestionnaire attribué à ' . $user->prenom . ' ' . $user->nom);
        } else {
            $this->command->warn('Utilisateur avec ID 1 non trouvé');
        }

        // Option 3: Créer un nouvel utilisateur gestionnaire si aucun n'existe
        if (User::count() === 0) {
            User::create([
                'nom' => 'Dieye',
                'prenom' => 'Adama',
                'email' => 'adamadieye780@gmail.com',
                'password' => bcrypt('passer123'), // Changez ce mot de passe!
                'role' => 'gestionnaire',
                'telephone' => '772386546', // Ajout du champ téléphone
            ]);
            $this->command->info('Nouvel utilisateur gestionnaire créé');
        }
    }
}
