<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Posts extends BaseController
{
    private PostModel $posts;

    public function __construct()
    {
        $this->posts = new PostModel();
    }

    public function index()
    {
        return view('admin/posts/index', [
            'title' => 'Artículos',
            'posts' => $this->posts->orderBy('updated_at', 'DESC')->paginate(15),
            'pager' => $this->posts->pager,
        ]);
    }

    public function new()
    {
        return view('admin/posts/form', [
            'title'  => 'Nuevo artículo',
            'post'   => [],
            'action' => site_url('admin/posts'),
        ]);
    }

    public function create()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collect();
        $data['slug'] = unique_slug($this->posts, $data['title']);

        if ($data['status'] === 'published') {
            $data['published_at'] = $data['published_at'] ?: date('Y-m-d H:i:s');
        }

        $data['cover_image'] = save_uploaded_image($this->request->getFile('cover_image'), 'posts');

        $id = $this->posts->insert($data, true);

        return redirect()->to('admin/posts/' . $id . '/editar')->with('success', 'Artículo creado.');
    }

    public function edit(int $id)
    {
        $post = $this->posts->find($id) ?? throw PageNotFoundException::forPageNotFound();

        return view('admin/posts/form', [
            'title'  => 'Editar artículo',
            'post'   => $post,
            'action' => site_url('admin/posts/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $post = $this->posts->find($id) ?? throw PageNotFoundException::forPageNotFound();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collect();

        if ($data['title'] !== $post['title']) {
            $data['slug'] = unique_slug($this->posts, $data['title'], $id);
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = $data['published_at'] ?: ($post['published_at'] ?: date('Y-m-d H:i:s'));
        }

        $cover = save_uploaded_image($this->request->getFile('cover_image'), 'posts');

        if ($cover !== null) {
            delete_uploaded_file($post['cover_image']);
            $data['cover_image'] = $cover;
        } elseif ($this->request->getPost('remove_cover')) {
            delete_uploaded_file($post['cover_image']);
            $data['cover_image'] = null;
        }

        $this->posts->update($id, $data);

        return redirect()->to('admin/posts/' . $id . '/editar')->with('success', 'Artículo actualizado.');
    }

    public function delete(int $id)
    {
        $post = $this->posts->find($id) ?? throw PageNotFoundException::forPageNotFound();

        delete_uploaded_file($post['cover_image']);
        $this->posts->delete($id);

        return redirect()->to('admin/posts')->with('success', 'Artículo eliminado.');
    }

    private function rules(): array
    {
        return [
            'title'        => 'required|max_length[200]',
            'category'     => 'permit_empty|max_length[100]',
            'tags'         => 'permit_empty|max_length[255]',
            'status'       => 'required|in_list[draft,published]',
            'published_at' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];
    }

    private function collect(): array
    {
        $post        = $this->request->getPost();
        $publishedAt = trim($post['published_at'] ?? '');

        return [
            'title'        => trim($post['title']),
            'content'      => $post['content'] ?? '',
            'category'     => trim($post['category'] ?? ''),
            'tags'         => normalize_tags($post['tags'] ?? ''),
            'status'       => $post['status'],
            'published_at' => $publishedAt !== '' ? date('Y-m-d H:i:s', strtotime($publishedAt)) : null,
        ];
    }
}
