<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Comments extends BaseController
{
    private const STATUSES = ['pending' => 'Pendientes', 'approved' => 'Aprobados', 'spam' => 'Spam'];

    private CommentModel $comments;

    public function __construct()
    {
        $this->comments = new CommentModel();
    }

    public function index()
    {
        $status = (string) $this->request->getGet('estado');
        $status = array_key_exists($status, self::STATUSES) ? $status : 'pending';

        $rows = $this->comments
            ->select('comments.*, posts.title AS post_title, posts.slug AS post_slug')
            ->join('posts', 'posts.id = comments.post_id')
            ->where('comments.status', $status)
            ->orderBy('comments.created_at', 'DESC')
            ->paginate(20);

        return view('admin/comments/index', [
            'title'    => 'Comentarios',
            'comments' => $rows,
            'pager'    => $this->comments->pager,
            'status'   => $status,
            'statuses' => self::STATUSES,
        ]);
    }

    public function setStatus(int $id)
    {
        $this->comments->find($id) ?? throw PageNotFoundException::forPageNotFound();

        $status = (string) $this->request->getPost('status');

        if (! array_key_exists($status, self::STATUSES)) {
            return redirect()->back()->with('error', 'Estado inválido.');
        }

        $this->comments->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Comentario actualizado.');
    }

    public function delete(int $id)
    {
        $this->comments->find($id) ?? throw PageNotFoundException::forPageNotFound();
        $this->comments->delete($id);

        return redirect()->back()->with('success', 'Comentario eliminado.');
    }
}
