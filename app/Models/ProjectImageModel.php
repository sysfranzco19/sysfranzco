<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectImageModel extends Model
{
    protected $table         = 'project_images';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['project_id', 'image_path', 'is_cover', 'sort_order'];

    public function forProject(int $projectId): array
    {
        return $this->where('project_id', $projectId)
            ->orderBy('is_cover', 'DESC')->orderBy('sort_order')->orderBy('id')
            ->findAll();
    }
}
