<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <h2>Iniciar sesión</h2>
  <form class="form" action="<?= site_url('login') ?>" method="post">
    <?= csrf_field() ?>
    <label for="email">Correo</label>
    <input id="email" type="email" name="email" value="<?= esc(old('email')) ?>" required autofocus>
    <label for="password">Contraseña</label>
    <input id="password" type="password" name="password" required>
    <button class="btn btn-primary" type="submit">Ingresar</button>
    <p class="alt-link">¿No tienes cuenta? <a href="<?= site_url('registro') ?>">Regístrate</a></p>
  </form>
</div></section>
<?= $this->endSection() ?>
