<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2>Proyectos</h2>
  <p style="margin-bottom:16px"><a class="btn btn-primary" href="<?= site_url('admin/proyectos/nuevo') ?>">Nuevo proyecto</a></p>
  <table class="tbl">
    <tr><th>Título</th><th>Categoría</th><th>Estado</th><th>Demo</th><th></th></tr>
    <?php foreach ($projects as $p): ?>
      <tr>
        <td><?= esc($p['title']) ?></td>
        <td><?= esc($p['category']) ?></td>
        <td><?= $p['status'] === 'published' ? 'Publicado' : 'Borrador' ?></td>
        <td><?= $p['demo_url'] ? ($p['requires_subscription'] ? 'Suscriptores' : 'Público') : '—' ?></td>
        <td>
          <a class="link" href="<?= site_url('admin/proyectos/' . $p['id'] . '/editar') ?>">Editar</a>
          <form action="<?= site_url('admin/proyectos/' . $p['id'] . '/eliminar') ?>" method="post" onsubmit="return confirm('¿Eliminar este proyecto y sus imágenes?')">
            <?= csrf_field() ?><button class="link" type="submit">Eliminar</button>
          </form>
        </td>
      </tr>
    <?php endforeach ?>
    <?php if (! $projects): ?><tr><td colspan="5">Aún no hay proyectos.</td></tr><?php endif ?>
  </table>
  <?= $pager->links() ?>
</div></section>
<?= $this->endSection() ?>
