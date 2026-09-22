<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2>Artículos</h2>
  <p style="margin-bottom:16px"><a class="btn btn-primary" href="<?= site_url('admin/posts/nuevo') ?>">Nuevo artículo</a></p>
  <table class="tbl">
    <tr><th>Título</th><th>Categoría</th><th>Estado</th><th>Publicación</th><th></th></tr>
    <?php foreach ($posts as $p): ?>
      <tr>
        <td><?= esc($p['title']) ?></td>
        <td><?= esc($p['category']) ?></td>
        <td><?= $p['status'] === 'published' ? 'Publicado' : 'Borrador' ?></td>
        <td><?= esc($p['published_at'] ?? '—') ?></td>
        <td>
          <a class="link" href="<?= site_url('admin/posts/' . $p['id'] . '/editar') ?>">Editar</a>
          <form action="<?= site_url('admin/posts/' . $p['id'] . '/eliminar') ?>" method="post" onsubmit="return confirm('¿Eliminar este artículo?')">
            <?= csrf_field() ?><button class="link" type="submit">Eliminar</button>
          </form>
        </td>
      </tr>
    <?php endforeach ?>
    <?php if (! $posts): ?><tr><td colspan="5">Aún no hay artículos.</td></tr><?php endif ?>
  </table>
  <?= $pager->links() ?>
</div></section>
<?= $this->endSection() ?>
