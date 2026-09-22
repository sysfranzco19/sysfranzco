<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2>Comentarios</h2>
  <div class="chips">
    <?php foreach ($statuses as $key => $label): ?>
      <a class="chip <?= $status === $key ? 'on' : '' ?>" href="<?= site_url('admin/comentarios') . '?estado=' . $key ?>"><?= esc($label) ?></a>
    <?php endforeach ?>
  </div>

  <?php foreach ($comments as $c): ?>
    <div class="card" style="margin-bottom:14px">
      <p class="muted">
        <strong><?= esc($c['author_name']) ?></strong>
        <?= $c['author_email'] ? '(' . esc($c['author_email']) . ')' : '' ?>
        · <?= esc(date('d/m/Y H:i', strtotime($c['created_at']))) ?>
        · IP <?= esc($c['ip_address']) ?>
        · en <a href="<?= site_url('blog/' . $c['post_slug']) ?>" style="text-decoration:underline"><?= esc($c['post_title']) ?></a>
      </p>
      <p style="margin:8px 0 12px"><?= nl2br(esc($c['content'])) ?></p>
      <div class="tbl">
        <?php foreach ($statuses as $key => $label): ?>
          <?php if ($key !== $c['status']): ?>
            <form action="<?= site_url('admin/comentarios/' . $c['id'] . '/estado') ?>" method="post">
              <?= csrf_field() ?><input type="hidden" name="status" value="<?= $key ?>">
              <button class="link" type="submit"><?= $key === 'approved' ? 'Aprobar' : ($key === 'spam' ? 'Marcar spam' : 'Pasar a pendiente') ?></button>
            </form>
          <?php endif ?>
        <?php endforeach ?>
        <form action="<?= site_url('admin/comentarios/' . $c['id'] . '/eliminar') ?>" method="post" onsubmit="return confirm('¿Eliminar comentario?')">
          <?= csrf_field() ?><button class="link" type="submit">Eliminar</button>
        </form>
      </div>
    </div>
  <?php endforeach ?>
  <?php if (! $comments): ?><p style="text-align:center">No hay comentarios en esta bandeja.</p><?php endif ?>
  <?= $pager->links() ?>
</div></section>
<?= $this->endSection() ?>
