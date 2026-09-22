<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $email    = env('admin.email');
        $password = env('admin.password');

        if (! $email || ! $password) {
            echo "Define admin.email y admin.password en .env antes de sembrar.\n";

            return;
        }

        $users = new UserModel();

        if ($users->where('email', $email)->first()) {
            echo "El admin {$email} ya existe.\n";

            return;
        }

        $users->insert([
            'name'          => 'Administrador',
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role'          => 'admin',
            'status'        => 'active',
        ]);
        echo "Admin {$email} creado.\n";
    }
}
