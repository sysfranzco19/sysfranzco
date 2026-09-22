<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w prose">
  <p class="muted"><a href="<?= site_url('blog') ?>">&larr; Blog</a></p>
  <h2 style="text-align:left;margin-bottom:6px"><?= esc($post['title']) ?></h2>
  <p class="muted" style="margin-bottom:18px">
    <?= esc(date('d/m/Y', strtotime($post['published_at']))) ?>
    <?php if ($post['category']): ?> · <a href="<?= site_url('blog') . '?categoria=' . urlencode($post['category']) ?>" style="text-decoration:underline"><?= esc($post['category']) ?></a><?php endif ?>
  </p>
  <?php if ($post['cover_image']): ?><img src="<?= base_url($post['cover_image']) ?>" alt="<?= esc($post['title']) ?>" style="border-radius:8px;margin-bottom:18px"><?php endif ?>

  <?= render_content($post['content']) ?>

  <?= ad_unit('article') ?>

  <div id="comentarios" style="margin-top:36px">
    <h3 style="margin:0 0 14px">Comentarios (<?= count($comments) ?>)</h3>
    <?php foreach ($comments as $c): ?>
      <div class="card" style="margin-bottom:12px">
        <p class="muted"><strong><?= esc($c['author_name']) ?></strong> · <?= esc(date('d/m/Y H:i', strtotime($c['created_at']))) ?></p>
        <p><?= nl2br(esc($c['content'])) ?></p>
      </div>
    <?php endforeach ?>

    <form class="form" style="max-width:none" action="<?= site_url('blog/' . $post['slug'] . '/comentarios') ?>" method="post">
      <?= csrf_field() ?>
      <label for="author_name">Nombre</label>
      <input id="author_name" name="author_name" maxlength="100" required value="<?= esc(old('author_name', session()->get('user_name') ?? '')) ?>">
      <label for="author_email">Correo (opcional, no se publica)</label>
      <input id="author_email" type="email" name="author_email" maxlength="150" value="<?= esc(old('author_email')) ?>">
      <label for="content">Comentario</label>
      <textarea id="content" name="content" maxlength="2000" required style="min-height:110px"><?= esc(old('content')) ?></textarea>
      <div style="position:absolute;left:-9999px" aria-hidden="true">
        <label for="website">No llenar</label>
        <input id="website" name="website" tabindex="-1" autocomplete="off">
      </div>
      <button class="btn btn-primary inline" type="submit">Enviar comentario</button>
      <p class="muted" style="margin-top:8px">Los comentarios son moderados antes de publicarse.</p>
    </form>
  </div>

  <?php if ($post['tags']): ?>
    <div class="chips" style="justify-content:flex-start;margin-top:20px">
      <?php foreach (explode(',', $post['tags']) as $t): ?>
        <a class="chip" href="<?= site_url('blog') . '?tag=' . urlencode($t) ?>">#<?= esc($t) ?></a>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</div></section>
<?= $this->endSection() ?>
