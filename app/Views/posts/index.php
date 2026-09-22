<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <h2>Blog</h2>
  <form action="<?= site_url('blog') ?>" method="get" class="form" style="margin-bottom:20px;max-width:420px">
    <input type="search" name="q" value="<?= esc($q) ?>" placeholder="Buscar artículos…" aria-label="Buscar">
  </form>
  <?php if ($categories): ?>
    <div class="chips">
      <a class="chip <?= $category === '' ? 'on' : '' ?>" href="<?= site_url('blog') ?>">Todos</a>
      <?php foreach ($categories as $c): ?>
        <a class="chip <?= $category === $c ? 'on' : '' ?>" href="<?= site_url('blog') . '?categoria=' . urlencode($c) ?>"><?= esc($c) ?></a>
      <?php endforeach ?>
    </div>
  <?php endif ?>
  <?php if ($tag !== ''): ?><p class="muted" style="text-align:center;margin-bottom:16px">Etiqueta: <strong><?= esc($tag) ?></strong> · <a href="<?= site_url('blog') ?>" style="text-decoration:underline">quitar</a></p><?php endif ?>

  <div class="grid">
    <?php foreach ($posts as $p): ?>
      <a class="card media" href="<?= site_url('blog/' . $p['slug']) ?>">
        <?php if ($p['cover_image']): ?><img class="cover" src="<?= base_url($p['cover_image']) ?>" alt="<?= esc($p['title']) ?>" loading="lazy"><?php endif ?>
        <div class="body">
          <h3><?= esc($p['title']) ?></h3>
          <p><?= esc(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($p['excerpt_source'] ?? ''))), 0, 140)) ?>…</p>
          <p class="muted"><?= esc(date('d/m/Y', strtotime($p['published_at']))) ?><?= $p['category'] ? ' · ' . esc($p['category']) : '' ?></p>
        </div>
      </a>
    <?php endforeach ?>
  </div>
  <?php if (! $posts): ?><p style="text-align:center">No hay artículos que coincidan.</p><?php endif ?>

  <?= ad_unit('inline') ?>
  <?= $pager->links() ?>
</div></section>
<?= $this->endSection() ?>
