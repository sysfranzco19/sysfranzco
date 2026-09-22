<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Restringe /admin/* a usuarios activos con rol admin.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('user_id')) {
            $session->set('redirect_url', current_url());

            return redirect()->to('login')->with('error', 'Inicia sesión para continuar.');
        }

        if ($session->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permiso para acceder al panel.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
