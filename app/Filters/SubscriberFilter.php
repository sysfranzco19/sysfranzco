<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Restringe los demos a usuarios autenticados (suscriptores o admin).
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

        if (! in_array($session->get('user_role'), ['subscriber', 'admin'], true)) {
            return redirect()->to('/')->with('error', 'Tu cuenta no tiene acceso a los demos.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
