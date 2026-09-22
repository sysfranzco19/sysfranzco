<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$v = static fn (string $k, $default = '') => old($k, $post[$k] ?? $default);
$publishedAt = $v('published_at');
$publishedAt = $publishedAt ? date('Y-m-d\TH:i', strtotime($publishedAt)) : '';
?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2><?= esc($title) ?></h2>
  <form class="form wide" action="<?= $action ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label for="title">Título</label>
    <input id="title" name="title" value="<?= esc($v('title')) ?>" required maxlength="200">

    <label for="content">Contenido (texto o HTML)</label>
    <textarea id="content" name="content" style="min-height:360px"><?= esc($v('content')) ?></textarea>

    <label for="category">Categoría</label>
    <input id="category" name="category" value="<?= esc($v('category')) ?>" maxlength="100" placeholder="Servidor, CodeIgniter, Hosting, General…">

    <label for="tags">Etiquetas (separadas por coma)</label>
    <input id="tags" name="tags" value="<?= esc($v('tags')) ?>" maxlength="255">

    <label for="status">Estado</label>
    <select id="status" name="status">
      <option value="draft" <?= $v('status', 'draft') === 'draft' ? 'selected' : '' ?>>Borrador</option>
      <option value="published" <?= $v('status', 'draft') === 'published' ? 'selected' : '' ?>>Publicado</option>
    </select>

    <label for="published_at">Fecha de publicación (vacío = ahora; futura = programado)</label>
    <input id="published_at" type="datetime-local" name="published_at" value="<?= esc($publishedAt) ?>">

    <label for="cover_image">Imagen de portada</label>
    <?php if (! empty($post['cover_image'])): ?>
      <img src="<?= base_url($post['cover_image']) ?>" alt="" style="max-width:240px;border-radius:6px;display:block;margin-bottom:8px">
      <label class="check"><input type="checkbox" name="remove_cover" value="1"> Quitar portada actual</label>
    <?php endif ?>
    <input id="cover_image" type="file" name="cover_image" accept="image/jpeg,image/png,image/webp,image/gif">

    <button class="btn btn-primary" type="submit">Guardar</button>
  </form>
</div></section>
<?= $this->endSection() ?>
