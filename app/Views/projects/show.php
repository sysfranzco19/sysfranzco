<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w prose">
  <p class="muted"><a href="<?= site_url('proyectos') ?>">&larr; Proyectos</a><?= $project['category'] ? ' · ' . esc($project['category']) : '' ?></p>
  <h2 style="text-align:left;margin-bottom:10px"><?= esc($project['title']) ?></h2>
  <?php if ($project['short_description']): ?><p><strong><?= esc($project['short_description']) ?></strong></p><?php endif ?>

  <?php if ($images): ?>
    <div class="gallery">
      <?php foreach ($images as $img): ?>
        <a href="<?= base_url($img['image_path']) ?>" target="_blank" rel="noopener"><img src="<?= base_url($img['image_path']) ?>" alt="<?= esc($project['title']) ?>" loading="lazy"></a>
      <?php endforeach ?>
    </div>
  <?php endif ?>

  <?php if ($videoId): ?>
    <div class="video"><iframe src="https://www.youtube-nocookie.com/embed/<?= esc($videoId, 'attr') ?>" title="<?= esc($project['title'], 'attr') ?>" loading="lazy" allowfullscreen></iframe></div>
  <?php endif ?>

  <?= render_content($project['description']) ?>

  <?php if ($demoLink): ?>
    <p style="margin-top:24px">
      <a class="btn btn-primary" href="<?= esc($demoLink, 'attr') ?>" <?= $project['requires_subscription'] ? '' : 'target="_blank" rel="noopener"' ?>>Ver demo</a>
      <?php if ($project['requires_subscription'] && ! session()->get('user_id')): ?>
        <span class="muted">Requiere iniciar sesión.</span>
      <?php endif ?>
    </p>
  <?php endif ?>

  <?= ad_unit('article') ?>
</div></section>
<?= $this->endSection() ?>
