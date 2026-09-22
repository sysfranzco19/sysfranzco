<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Demo extends BaseController
{
    /**
     * Ruta protegida por el filtro "subscriber": solo llega aquí un usuario con sesión.
     */
    public function show(string $slug)
    {
        $project = (new ProjectModel())->where('slug', $slug)->where('status', 'published')->first();

        if (! $project || ! $project['demo_url']) {
            throw PageNotFoundException::forPageNotFound();
        }

        return redirect()->to($project['demo_url']);
    }
}
