<?php

namespace App\Controllers;

use App\Models\ProjectImageModel;
use App\Models\ProjectModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Projects extends BaseController
{
    public function index()
    {
        $projects = new ProjectModel();
        $category = trim((string) $this->request->getGet('categoria'));

        return view('projects/index', [
            'ads'        => true,
            'title'      => 'Proyectos | Sysfranzco',
            'description' => 'Aplicaciones y sistemas desarrollados por Sysfranzco.',
            'projects'   => $projects->publishedWithCover($category ?: null)->paginate(9),
            'pager'      => $projects->pager,
            'categories' => $projects->publishedCategories(),
            'category'   => $category,
        ]);
    }

    public function show(string $slug)
    {
        $project = (new ProjectModel())->where('slug', $slug)->where('status', 'published')->first()
            ?? throw PageNotFoundException::forPageNotFound();

        // Para demos restringidos nunca se expone la URL real: se pasa por /demo/{slug}, que exige sesión.
        $demoLink = null;

        if ($project['demo_url']) {
            $demoLink = $project['requires_subscription'] ? site_url('demo/' . $project['slug']) : $project['demo_url'];
        }

        return view('projects/show', [
            'ads'         => true,
            'title'       => $project['title'] . ' | Sysfranzco',
            'description' => $project['short_description'] ?: null,
            'project'     => $project,
            'images'      => (new ProjectImageModel())->forProject((int) $project['id']),
            'videoId'     => youtube_embed_id($project['youtube_url']),
            'demoLink'    => $demoLink,
        ]);
    }
}
