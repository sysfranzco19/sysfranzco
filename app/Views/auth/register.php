<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <h2>Crear cuenta</h2>
  <form class="form" action="<?= site_url('registro') ?>" method="post">
    <?= csrf_field() ?>
    <label for="name">Nombre</label>
    <input id="name" type="text" name="name" value="<?= esc(old('name')) ?>" required autofocus>
    <label for="email">Correo</label>
    <input id="email" type="email" name="email" value="<?= esc(old('email')) ?>" required>
    <label for="password">Contraseña (mínimo 8 caracteres)</label>
    <input id="password" type="password" name="password" required minlength="8">
    <label for="password_confirm">Repite la contraseña</label>
    <input id="password_confirm" type="password" name="password_confirm" required>
    <button class="btn btn-primary" type="submit">Registrarme</button>
    <p class="alt-link">¿Ya tienes cuenta? <a href="<?= site_url('login') ?>">Inicia sesión</a></p>
  </form>
</div></section>
<?= $this->endSection() ?>
