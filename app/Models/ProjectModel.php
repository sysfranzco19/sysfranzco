<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table         = 'projects';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'title', 'slug', 'short_description', 'description', 'category',
        'status', 'demo_url', 'requires_subscription', 'youtube_url',
    ];

    /**
     * Proyectos publicados con la ruta de su portada (cover_path).
     */
    public function publishedWithCover(?string $category = null): self
    {
        $this->select('projects.*, (SELECT image_path FROM project_images pi WHERE pi.project_id = projects.id ORDER BY pi.is_cover DESC, pi.sort_order ASC, pi.id ASC LIMIT 1) AS cover_path', false)
            ->where('projects.status', 'published')
            ->orderBy('projects.created_at', 'DESC');

        if ($category) {
            $this->where('projects.category', $category);
        }

        return $this;
    }

    public function publishedCategories(): array
    {
        $rows = $this->builder()->select('category')->distinct()
            ->where('status', 'published')->where('category IS NOT NULL')->where('category !=', '')
            ->orderBy('category')->get()->getResultArray();

        return array_column($rows, 'category');
    }
}
