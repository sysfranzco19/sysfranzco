<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/');
        }

        return view('auth/login', ['title' => 'Iniciar sesión']);
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Correo o contraseña inválidos.');
        }

        $email = (string) $this->request->getPost('email');
        $user  = (new UserModel())->where('email', $email)->first();

        // Mismo mensaje para usuario inexistente, clave errónea o cuenta inactiva.
        if (! $user || $user['status'] !== 'active'
            || ! password_verify((string) $this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Correo o contraseña incorrectos.');
        }

        $session = session();
        $target  = $session->get('redirect_url');

        $session->regenerate(true);
        $session->set([
            'user_id'   => (int) $user['id'],
            'user_name' => $user['name'],
            'user_role' => $user['role'],
        ]);
        $session->remove('redirect_url');

        if ($target) {
            return redirect()->to($target);
        }

        return redirect()->to($user['role'] === 'admin' ? 'admin' : '/');
    }

    public function register()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/');
        }

        return view('auth/register', ['title' => 'Crear cuenta']);
    }

    public function attemptRegister()
    {
        $rules = [
            'name'             => 'required|min_length[2]|max_length[150]',
            'email'            => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password'         => 'required|min_length[8]|max_length[72]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // El rol nunca viene del formulario: los registros públicos son siempre suscriptores.
        (new UserModel())->insert([
            'name'          => trim((string) $this->request->getPost('name')),
            'email'         => (string) $this->request->getPost('email'),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'subscriber',
            'status'        => 'active',
        ]);

        return redirect()->to('login')->with('success', 'Cuenta creada. Ya puedes iniciar sesión.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}
