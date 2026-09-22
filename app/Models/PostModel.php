<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table         = 'posts';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'title', 'slug', 'content', 'category', 'tags',
        'cover_image', 'status', 'published_at',
    ];

    /**
     * Artículos visibles al público (publicados y con fecha ya cumplida).
     */
    public function published(): self
    {
        return $this->where('status', 'published')
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC');
    }

    public function publishedCategories(): array
    {
        $rows = $this->builder()->select('category')->distinct()
            ->where('status', 'published')->where('category IS NOT NULL')->where('category !=', '')
            ->orderBy('category')->get()->getResultArray();

        return array_column($rows, 'category');
    }
}
