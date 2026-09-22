<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectImageModel;
use App\Models\ProjectModel;

class Projects extends BaseController
{
    private ProjectModel $projects;
    private ProjectImageModel $images;

    public function __construct()
    {
        $this->projects = new ProjectModel();
        $this->images   = new ProjectImageModel();
    }

    public function index()
    {
        return view('admin/projects/index', [
            'title'    => 'Proyectos',
            'projects' => $this->projects->orderBy('updated_at', 'DESC')->paginate(15),
            'pager'    => $this->projects->pager,
        ]);
    }

    public function new()
    {
        return view('admin/projects/form', [
            'title'   => 'Nuevo proyecto',
            'project' => [],
            'images'  => [],
            'action'  => site_url('admin/proyectos'),
        ]);
    }

    public function create()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collect();
        $data['slug'] = unique_slug($this->projects, $data['title']);
        $id = $this->projects->insert($data, true);

        $this->storeImages((int) $id);

        return redirect()->to('admin/proyectos/' . $id . '/editar')->with('success', 'Proyecto creado.');
    }

    public function edit(int $id)
    {
        $project = $this->projects->find($id) ?? throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('admin/projects/form', [
            'title'   => 'Editar proyecto',
            'project' => $project,
            'images'  => $this->images->forProject($id),
            'action'  => site_url('admin/proyectos/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $project = $this->projects->find($id) ?? throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collect();

        // El slug solo cambia si cambia el título, para no romper enlaces existentes sin motivo.
        if ($data['title'] !== $project['title']) {
            $data['slug'] = unique_slug($this->projects, $data['title'], $id);
        }

        $this->projects->update($id, $data);
        $this->storeImages($id);

        return redirect()->to('admin/proyectos/' . $id . '/editar')->with('success', 'Proyecto actualizado.');
    }

    public function delete(int $id)
    {
        $this->projects->find($id) ?? throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        foreach ($this->images->forProject($id) as $image) {
            delete_uploaded_file($image['image_path']);
        }

        $this->projects->delete($id); // las filas de project_images caen por FK en cascada

        return redirect()->to('admin/proyectos')->with('success', 'Proyecto eliminado.');
    }

    public function deleteImage(int $id)
    {
        $image = $this->images->find($id) ?? throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        delete_uploaded_file($image['image_path']);
        $this->images->delete($id);

        return redirect()->to('admin/proyectos/' . $image['project_id'] . '/editar')->with('success', 'Imagen eliminada.');
    }

    public function coverImage(int $id)
    {
        $image = $this->images->find($id) ?? throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->images->builder()->where('project_id', $image['project_id'])->update(['is_cover' => 0]);
        $this->images->update($id, ['is_cover' => 1]);

        return redirect()->to('admin/proyectos/' . $image['project_id'] . '/editar')->with('success', 'Portada actualizada.');
    }

    private function rules(): array
    {
        return [
            'title'             => 'required|max_length[150]',
            'short_description' => 'permit_empty|max_length[255]',
            'category'          => 'permit_empty|max_length[100]',
            'status'            => 'required|in_list[draft,published]',
            'demo_url'          => 'permit_empty|max_length[255]|valid_url_strict[http,https]',
            'youtube_url'       => 'permit_empty|max_length[255]|valid_url_strict[http,https]',
        ];
    }

    private function collect(): array
    {
        $post = $this->request->getPost();

        return [
            'title'                 => trim($post['title']),
            'short_description'     => trim($post['short_description'] ?? ''),
            'description'           => $post['description'] ?? '',
            'category'              => trim($post['category'] ?? ''),
            'status'                => $post['status'],
            'demo_url'              => trim($post['demo_url'] ?? ''),
            'requires_subscription' => isset($post['requires_subscription']) ? 1 : 0,
            'youtube_url'           => trim($post['youtube_url'] ?? ''),
        ];
    }

    private function storeImages(int $projectId): void
    {
        $files = $this->request->getFileMultiple('images') ?: [];
        $hasCover = $this->images->where('project_id', $projectId)->where('is_cover', 1)->countAllResults() > 0;
        $order    = $this->images->where('project_id', $projectId)->countAllResults();

        foreach ($files as $file) {
            $path = save_uploaded_image($file, 'projects');

            if ($path === null) {
                continue;
            }

            $this->images->insert([
                'project_id' => $projectId,
                'image_path' => $path,
                'is_cover'   => $hasCover ? 0 : 1,
                'sort_order' => $order++,
            ]);
            $hasCover = true;
        }
    }
}
