<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function index()
    {
        $q = trim((string) $this->request->getGet('q'));

        if ($q !== '') {
            $this->users->groupStart()->like('name', $q)->orLike('email', $q)->groupEnd();
        }

        return view('admin/users/index', [
            'title'  => 'Usuarios',
            'users'  => $this->users->orderBy('created_at', 'DESC')->paginate(20),
            'pager'  => $this->users->pager,
            'q'      => $q,
            'selfId' => (int) session()->get('user_id'),
        ]);
    }

    public function toggleStatus(int $id)
    {
        $user = $this->target($id);

        if ($blocked = $this->guardSelf($id)) {
            return $blocked;
        }

        $new = $user['status'] === 'active' ? 'inactive' : 'active';
        $this->users->update($id, ['status' => $new]);

        return redirect()->back()->with('success', $new === 'active' ? 'Usuario activado.' : 'Usuario desactivado.');
    }

    public function setRole(int $id)
    {
        $user = $this->target($id);
        $role = (string) $this->request->getPost('role');

        if (! in_array($role, ['admin', 'subscriber'], true)) {
            return redirect()->back()->with('error', 'Rol inválido.');
        }

        if ($blocked = $this->guardSelf($id)) {
            return $blocked;
        }

        $this->users->update($id, ['role' => $role]);

        return redirect()->back()->with('success', 'Rol de ' . $user['name'] . ' actualizado.');
    }

    public function delete(int $id)
    {
        $this->target($id);

        if ($blocked = $this->guardSelf($id)) {
            return $blocked;
        }

        $this->users->delete($id);

        return redirect()->back()->with('success', 'Usuario eliminado.');
    }

    private function target(int $id): array
    {
        return $this->users->find($id) ?? throw PageNotFoundException::forPageNotFound();
    }

    /**
     * Evita que el admin se quite el acceso a sí mismo (y que el sitio se quede sin admin).
     */
    private function guardSelf(int $id)
    {
        if ($id === (int) session()->get('user_id')) {
            return redirect()->back()->with('error', 'No puedes modificar tu propia cuenta desde aquí.');
        }

        return null;
    }
}
