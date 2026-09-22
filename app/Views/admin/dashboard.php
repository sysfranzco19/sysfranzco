<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2>Panel de administración</h2>
  <div class="grid">
    <?php foreach ($counts as $label => $total): ?>
      <div class="card"><h3><?= esc($label) ?></h3><div class="num"><?= (int) $total ?></div></div>
    <?php endforeach ?>
  </div>
</div></section>
<?= $this->endSection() ?>
