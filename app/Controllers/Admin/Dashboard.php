<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = db_connect();

        return view('admin/dashboard', [
            'title'  => 'Panel de administración',
            'counts' => [
                'Proyectos'   => $db->table('projects')->countAllResults(),
                'Artículos'   => $db->table('posts')->countAllResults(),
                'Suscriptores' => $db->table('users')->where('role', 'subscriber')->countAllResults(),
            ],
        ]);
    }
}
