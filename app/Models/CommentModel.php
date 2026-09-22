<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table         = 'comments';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['post_id', 'author_name', 'author_email', 'content', 'status', 'ip_address'];

    public function approvedForPost(int $postId): array
    {
        return $this->where('post_id', $postId)->where('status', 'approved')
            ->orderBy('created_at', 'ASC')->findAll();
    }

    /**
     * Comentarios enviados desde una IP en los últimos $minutes minutos (límite anti-flood).
     */
    public function recentFromIp(string $ip, int $minutes = 10): int
    {
        return $this->where('ip_address', $ip)
            ->where('created_at >=', date('Y-m-d H:i:s', time() - $minutes * 60))
            ->countAllResults();
    }
}
