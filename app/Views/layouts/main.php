<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Sysfranzco | Sistemas Informáticos y Asistencia Técnica') ?></title>
<meta name="description" content="<?= esc($description ?? 'Sysfranzco: desarrollo de sistemas informáticos y asistencia técnica para empresas y hogares.') ?>">
<style>
:root{--c:#0b5ed7;--d:#0a2540;--g:#f4f7fb;--t:#333}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,Segoe UI,Arial,sans-serif;color:var(--t);line-height:1.6}
a{color:inherit;text-decoration:none}
.w{max-width:1000px;margin:auto;padding:0 20px}
header{background:var(--d);color:#fff;position:sticky;top:0;z-index:10}
header .w{display:flex;justify-content:space-between;align-items:center;height:60px}
header b{font-size:1.3rem}header b span{color:#5aa2ff}
nav{display:flex;align-items:center;gap:20px;font-size:.95rem}nav a:hover,nav button:hover{color:#5aa2ff}
nav form{display:inline}
nav button{background:none;border:0;color:inherit;font:inherit;cursor:pointer}
.hero{background:linear-gradient(135deg,var(--d),var(--c));color:#fff;text-align:center;padding:90px 0}
.hero h1{font-size:2.4rem;margin-bottom:12px}
.hero p{max-width:600px;margin:0 auto 26px;opacity:.9}
.btn{display:inline-block;background:#fff;color:var(--c);padding:12px 28px;border-radius:6px;font-weight:600}
.btn-primary{background:var(--c);color:#fff;border:0;cursor:pointer;font:inherit;font-weight:600}
section{padding:60px 0}section.alt{background:var(--g)}
h2{text-align:center;color:var(--d);margin-bottom:34px}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px}
.card{background:#fff;border-radius:8px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,.08)}
.card h3{color:var(--c);margin-bottom:8px}
.card .num{font-size:2.2rem;font-weight:700;color:var(--d)}
#nosotros p{max-width:700px;margin:auto;text-align:center}
#contacto{text-align:center}
.form{max-width:420px;margin:auto}
.form label{display:block;margin:14px 0 4px;font-weight:600;font-size:.9rem}
.form input{width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:6px;font:inherit}
.form .btn{width:100%;margin-top:20px}
.form p.alt-link{text-align:center;margin-top:16px;font-size:.9rem}
.form p.alt-link a{color:var(--c)}
.flash{padding:12px 20px;text-align:center;font-size:.95rem}
.flash.error{background:#fde8e8;color:#9b1c1c}
.flash.success{background:#e3f6e8;color:#1e6b34}
.flash ul{list-style:none}
.ad{margin:24px 0;text-align:center;min-height:0}
.pagination{list-style:none;display:flex;gap:6px;justify-content:center;margin-top:30px;flex-wrap:wrap}
.pagination a,.pagination li.active a{display:block;padding:6px 12px;border:1px solid #cbd5e1;border-radius:6px}
.pagination li.active a{background:var(--c);color:#fff;border-color:var(--c)}
.chips{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;margin-bottom:28px}
.chip{padding:4px 14px;border:1px solid #cbd5e1;border-radius:99px;font-size:.9rem}
.chip.on{background:var(--c);color:#fff;border-color:var(--c)}
.cover{width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:8px 8px 0 0;display:block;background:var(--g)}
.card.media{padding:0;overflow:hidden}.card.media .body{padding:18px 20px}
.muted{color:#64748b;font-size:.85rem}
.prose{max-width:760px;margin:auto}.prose img{max-width:100%;height:auto}.prose pre{background:var(--d);color:#e2e8f0;padding:14px;border-radius:6px;overflow:auto;margin:14px 0}.prose p,.prose ul,.prose ol{margin:0 0 14px}.prose h2,.prose h3{text-align:left;margin:24px 0 10px}
.gallery{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;margin:20px 0}.gallery img{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:6px}
.video{position:relative;aspect-ratio:16/9;margin:20px 0}.video iframe{position:absolute;inset:0;width:100%;height:100%;border:0;border-radius:8px}
.tbl{width:100%;border-collapse:collapse;font-size:.92rem}.tbl th,.tbl td{padding:8px 10px;border-bottom:1px solid #e2e8f0;text-align:left}
.tbl form{display:inline}.link{background:none;border:0;color:var(--c);cursor:pointer;font:inherit;text-decoration:underline;padding:0}
.admin-nav{display:flex;gap:18px;justify-content:center;margin-bottom:28px}.admin-nav a{color:var(--c);font-weight:600}
.form.wide{max-width:760px}.form select,.form textarea{width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:6px;font:inherit}.form textarea{min-height:220px}
.form .check{display:flex;gap:8px;align-items:center;margin-top:14px}.form .check input{width:auto}
.form .btn.inline{width:auto}
footer{background:var(--d);color:#cbd5e1;text-align:center;padding:20px;font-size:.9rem}
</style>
<?= ! empty($ads) ? adsense_script() : "" ?>
<?= $this->renderSection("head") ?>
</head>
<body>
<header><div class="w">
  <a href="<?= site_url('/') ?>"><b>Sys<span>franzco</span></b></a>
  <nav>
    <a href="<?= site_url("proyectos") ?>">Proyectos</a>
    <a href="<?= site_url("blog") ?>">Blog</a>
    <?php if (session()->get('user_id')): ?>
      <?php if (session()->get('user_role') === 'admin'): ?><a href="<?= site_url('admin') ?>">Panel</a><?php endif ?>
      <span><?= esc(session()->get('user_name')) ?></span>
      <form action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit">Salir</button>
      </form>
    <?php else: ?>
      <a href="<?= site_url('login') ?>">Ingresar</a>
      <a href="<?= site_url('registro') ?>">Registrarse</a>
    <?php endif ?>
  </nav>
</div></header>

<?php if (session()->getFlashdata('error')): ?>
  <div class="flash error"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="flash success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif ?>
<?php if (session()->getFlashdata('errors')): ?>
  <div class="flash error"><ul>
    <?php foreach (session()->getFlashdata('errors') as $error): ?><li><?= esc($error) ?></li><?php endforeach ?>
  </ul></div>
<?php endif ?>

<?= $this->renderSection('content') ?>

<footer>&copy; <?= date("Y") ?> Sysfranzco – Sistemas Informáticos y Asistencia Técnica · <a href="<?= site_url("privacidad") ?>" style="text-decoration:underline">Privacidad</a></footer>
</body>
</html>
