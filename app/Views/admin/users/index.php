<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section><div class="w">
  <?= $this->include('admin/_nav') ?>
  <h2>Usuarios</h2>
  <form action="<?= site_url('admin/usuarios') ?>" method="get" class="form" style="margin-bottom:20px;max-width:420px">
    <input type="search" name="q" value="<?= esc($q) ?>" placeholder="Buscar por nombre o correo…" aria-label="Buscar">
  </form>
  <table class="tbl">
    <tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Alta</th><th></th></tr>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= esc($u['name']) ?></td>
        <td><?= esc($u['email']) ?></td>
        <td><?= $u['role'] === 'admin' ? 'Admin' : 'Suscriptor' ?></td>
        <td><?= $u['status'] === 'active' ? 'Activo' : 'Inactivo' ?></td>
        <td><?= esc(date('d/m/Y', strtotime($u['created_at']))) ?></td>
        <td>
          <?php if ((int) $u['id'] === $selfId): ?>
            <span class="muted">Tu cuenta</span>
          <?php else: ?>
            <form action="<?= site_url('admin/usuarios/' . $u['id'] . '/estado') ?>" method="post">
              <?= csrf_field() ?><button class="link" type="submit"><?= $u['status'] === 'active' ? 'Desactivar' : 'Activar' ?></button>
            </form>
            <form action="<?= site_url('admin/usuarios/' . $u['id'] . '/rol') ?>" method="post" onsubmit="return confirm('¿Cambiar el rol de este usuario?')">
              <?= csrf_field() ?>
              <input type="hidden" name="role" value="<?= $u['role'] === 'admin' ? 'subscriber' : 'admin' ?>">
              <button class="link" type="submit"><?= $u['role'] === 'admin' ? 'Hacer suscriptor' : 'Hacer admin' ?></button>
            </form>
            <form action="<?= site_url('admin/usuarios/' . $u['id'] . '/eliminar') ?>" method="post" onsubmit="return confirm('¿Eliminar este usuario?')">
              <?= csrf_field() ?><button class="link" type="submit">Eliminar</button>
            </form>
          <?php endif ?>
        </td>
      </tr>
    <?php endforeach ?>
    <?php if (! $users): ?><tr><td colspan="6">Sin resultados.</td></tr><?php endif ?>
  </table>
  <?= $pager->links() ?>
</div></section>
<?= $this->endSection() ?>
