<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $v = static fn (string $k, $default = '') => old($k, $project[$k] ?? $default); ?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2><?= esc($title) ?></h2>
  <form class="form wide" action="<?= $action ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label for="title">Título</label>
    <input id="title" name="title" value="<?= esc($v('title')) ?>" required maxlength="150">

    <label for="short_description">Resumen (tarjetas)</label>
    <input id="short_description" name="short_description" value="<?= esc($v('short_description')) ?>" maxlength="255">

    <label for="description">Descripción (texto o HTML)</label>
    <textarea id="description" name="description"><?= esc($v('description')) ?></textarea>

    <label for="category">Categoría</label>
    <input id="category" name="category" value="<?= esc($v('category')) ?>" maxlength="100" placeholder="Web App, Sistema de cobros, Educativo…">

    <label for="status">Estado</label>
    <select id="status" name="status">
      <option value="draft" <?= $v('status', 'draft') === 'draft' ? 'selected' : '' ?>>Borrador</option>
      <option value="published" <?= $v('status', 'draft') === 'published' ? 'selected' : '' ?>>Publicado</option>
    </select>

    <label for="demo_url">URL del demo</label>
    <input id="demo_url" type="url" name="demo_url" value="<?= esc($v('demo_url')) ?>" maxlength="255">

    <label class="check">
      <input type="checkbox" name="requires_subscription" value="1" <?= $v('requires_subscription', 0) ? 'checked' : '' ?>>
      El demo requiere sesión (suscriptor)
    </label>

    <label for="youtube_url">Video de YouTube</label>
    <input id="youtube_url" type="url" name="youtube_url" value="<?= esc($v('youtube_url')) ?>" maxlength="255">

    <label for="images">Agregar imágenes (JPG, PNG, WebP o GIF, máx. 3 MB c/u)</label>
    <input id="images" type="file" name="images[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple>

    <button class="btn btn-primary" type="submit">Guardar</button>
  </form>

  <?php if ($images): ?>
    <h2 style="margin-top:40px">Imágenes</h2>
    <div class="gallery">
      <?php foreach ($images as $img): ?>
        <div>
          <img src="<?= base_url($img['image_path']) ?>" alt="">
          <?php if ($img['is_cover']): ?>
            <p class="muted">Portada</p>
          <?php else: ?>
            <form action="<?= site_url('admin/proyectos/imagenes/' . $img['id'] . '/portada') ?>" method="post" style="display:inline">
              <?= csrf_field() ?><button class="link" type="submit">Hacer portada</button>
            </form>
          <?php endif ?>
          <form action="<?= site_url('admin/proyectos/imagenes/' . $img['id'] . '/eliminar') ?>" method="post" style="display:inline" onsubmit="return confirm('¿Eliminar imagen?')">
            <?= csrf_field() ?><button class="link" type="submit">Eliminar</button>
          </form>
        </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</div></section>
<?= $this->endSection() ?>
