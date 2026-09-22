<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <h2>Proyectos</h2>
  <?php if ($categories): ?>
    <div class="chips">
      <a class="chip <?= $category === '' ? 'on' : '' ?>" href="<?= site_url('proyectos') ?>">Todos</a>
      <?php foreach ($categories as $c): ?>
        <a class="chip <?= $category === $c ? 'on' : '' ?>" href="<?= site_url('proyectos') . '?categoria=' . urlencode($c) ?>"><?= esc($c) ?></a>
      <?php endforeach ?>
    </div>
  <?php endif ?>

  <div class="grid">
    <?php foreach ($projects as $i => $p): ?>
      <a class="card media" href="<?= site_url('proyectos/' . $p['slug']) ?>">
        <?php if ($p['cover_path']): ?><img class="cover" src="<?= base_url($p['cover_path']) ?>" alt="<?= esc($p['title']) ?>" loading="lazy"><?php endif ?>
        <div class="body">
          <h3><?= esc($p['title']) ?></h3>
          <p><?= esc($p['short_description']) ?></p>
          <?php if ($p['category']): ?><p class="muted"><?= esc($p['category']) ?></p><?php endif ?>
        </div>
      </a>
    <?php endforeach ?>
  </div>
  <?php if (! $projects): ?><p style="text-align:center">Aún no hay proyectos publicados.</p><?php endif ?>

  <?= ad_unit('inline') ?>
  <?= $pager->links() ?>
</div></section>
<?= $this->endSection() ?>
