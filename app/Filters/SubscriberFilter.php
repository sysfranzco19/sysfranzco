<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Restringe los demos a usuarios activos (suscriptores o admin).
 * Visitantes son enviados al login y regresan a la URL solicitada.
 */
class SubscriberFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('user_id')) {
            $session->set('redirect_url', current_url());

            return redirect()->to('login')->with('error', 'Inicia sesión para ver los demos.');
        }

        $user = (new UserModel())->find($session->get('user_id'));

        if (! $user || $user['status'] !== 'active') {
            $session->destroy();

            return redirect()->to('login')->with('error', 'Tu cuenta no está activa.');
        }

        $session->set('user_role', $user['role']);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
