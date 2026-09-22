<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\PostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Comments extends BaseController
{
    private const MAX_PER_WINDOW = 3;

    public function store(string $slug)
    {
        $post = (new PostModel())->published()->where('slug', $slug)->first()
            ?? throw PageNotFoundException::forPageNotFound();

        $back    = 'blog/' . $post['slug'] . '#comentarios';
        $thanks  = 'Gracias. Tu comentario se publicará cuando sea aprobado.';
        $comments = new CommentModel();

        // Honeypot: un humano nunca ve este campo. Se responde igual que un envío válido.
        if (trim((string) $this->request->getPost('website')) !== '') {
            return redirect()->to($back)->with('success', $thanks);
        }

        $rules = [
            'author_name'  => 'required|min_length[2]|max_length[100]',
            'author_email' => 'permit_empty|valid_email|max_length[150]',
            'content'      => 'required|min_length[3]|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to($back)->withInput()->with('errors', $this->validator->getErrors());
        }

        $ip = $this->request->getIPAddress();

        if ($comments->recentFromIp($ip) >= self::MAX_PER_WINDOW) {
            return redirect()->to($back)->withInput()->with('error', 'Estás comentando demasiado rápido. Intenta de nuevo en unos minutos.');
        }

        $content = trim((string) $this->request->getPost('content'));

        // Muchos enlaces = casi seguro spam: se guarda ya marcado para no saturar la moderación.
        $links  = preg_match_all('~https?://|www\.~i', $content);
        $status = $links > 2 ? 'spam' : 'pending';

        $comments->insert([
            'post_id'      => $post['id'],
            'author_name'  => trim((string) $this->request->getPost('author_name')),
            'author_email' => trim((string) $this->request->getPost('author_email')) ?: null,
            'content'      => $content,
            'status'       => $status,
            'ip_address'   => $ip,
        ]);

        return redirect()->to($back)->with('success', $thanks);
    }
}
