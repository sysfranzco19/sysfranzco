<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\PostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Posts extends BaseController
{
    public function index()
    {
        $posts    = new PostModel();
        $category = trim((string) $this->request->getGet('categoria'));
        $tag      = trim(mb_strtolower((string) $this->request->getGet('tag')));
        $q        = trim((string) $this->request->getGet('q'));

        $posts->published()->select('id, title, slug, category, tags, cover_image, published_at, SUBSTRING(content, 1, 600) AS excerpt_source');

        if ($category !== '') {
            $posts->where('category', $category);
        }

        if ($tag !== '') {
            $posts->where('FIND_IN_SET(' . db_connect()->escape($tag) . ', tags) >', 0, false);
        }

        if ($q !== '') {
            $posts->groupStart()->like('title', $q)->orLike('content', $q)->groupEnd();
        }

        return view('posts/index', [
            'ads'         => true,
            'title'       => 'Blog | Sysfranzco',
            'description' => 'Tutoriales y soluciones a problemas de servidor, hosting y CodeIgniter.',
            'posts'       => $posts->paginate(8),
            'pager'       => $posts->pager,
            'categories'  => (new PostModel())->publishedCategories(),
            'category'    => $category,
            'tag'         => $tag,
            'q'           => $q,
        ]);
    }

    public function show(string $slug)
    {
        $post = (new PostModel())->published()->where('slug', $slug)->first()
            ?? throw PageNotFoundException::forPageNotFound();

        return view('posts/show', [
            'ads'         => true,
            'title'       => $post['title'] . ' | Sysfranzco',
            'description' => mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($post['content'] ?? ''))), 0, 155),
            'post'        => $post,
            'comments'    => (new CommentModel())->approvedForPost((int) $post['id']),
        ]);
    }
}
