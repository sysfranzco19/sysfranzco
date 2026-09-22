<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Restringe /admin/* a usuarios activos con rol admin.
 * Rol y estado se releen de la BD en cada petición, así que desactivar o
 * degradar a un usuario surte efecto de inmediato.
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

        $user = (new UserModel())->find($session->get('user_id'));

        if (! $user || $user['status'] !== 'active') {
            $session->destroy();

            return redirect()->to('login')->with('error', 'Tu cuenta no está activa.');
        }

        $session->set('user_role', $user['role']);

        if ($user['role'] !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permiso para acceder al panel.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
