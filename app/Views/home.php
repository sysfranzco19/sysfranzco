<?= $this->extend('layouts/main') ?>

<?= $this->section('head') ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2740977378426451"
     crossorigin="anonymous"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="hero"><div class="w">
  <h1>Sistemas informáticos y asistencia técnica</h1>
  <p>Soluciones tecnológicas a medida y soporte confiable para tu empresa u hogar.</p>
  <a class="btn" href="#contacto">Contáctanos</a>
</div></div>

<section id="servicios"><div class="w">
  <h2>Nuestros servicios</h2>
  <div class="grid">
    <div class="card"><h3>Desarrollo de sistemas</h3><p>Aplicaciones web y sistemas de gestión adaptados a tu negocio.</p></div>
    <div class="card"><h3>Asistencia técnica</h3><p>Reparación y mantenimiento de computadoras, laptops e impresoras.</p></div>
    <div class="card"><h3>Redes y seguridad</h3><p>Instalación de redes, WiFi, cámaras y protección de tus datos.</p></div>
    <div class="card"><h3>Soporte remoto</h3><p>Atención rápida a distancia para resolver tus incidencias.</p></div>
  </div>
</div></section>

<section id="nosotros" class="alt"><div class="w">
  <h2>Sobre Sysfranzco</h2>
  <p>Somos una empresa dedicada a ofrecer sistemas informáticos y asistencia técnica con compromiso, rapidez y trato personalizado.</p>
</div></section>

<section id="contacto"><div class="w">
  <h2>Contacto</h2>
  <p>Correo: franz.condori.calderon@gmail.com</p>
</div></section>
<?= $this->endSection() ?>
