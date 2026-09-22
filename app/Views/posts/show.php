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

  <?php if ($post['tags']): ?>
    <div class="chips" style="justify-content:flex-start;margin-top:20px">
      <?php foreach (explode(',', $post['tags']) as $t): ?>
        <a class="chip" href="<?= site_url('blog') . '?tag=' . urlencode($t) ?>">#<?= esc($t) ?></a>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</div></section>
<?= $this->endSection() ?>
