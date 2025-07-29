<?php
// como_actuar.php
session_start();
require 'conn.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>¿Cómo Actuar? – Pet Homeless</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <header
    class="banner text-white text-center d-flex align-items-center justify-content-center reveal"
    style="background-image: url('images/howto-banner.jpg'); min-height: 40vh;"
  >
    <div class="container">
      <h1>¿Cómo Actuar?</h1>
      <p class="lead">Guías rápidas para cuando encuentres un animal en situación de riesgo</p>
    </div>
  </header>

  <main class="container my-5">
   
    <section id="herido" class="mb-5 reveal">
      <div class="row g-4 align-items-center">
        <div class="col-md-5">
          <i class="fa-solid fa-hand-holding-medical fa-3x text-danger mb-3"></i>
          <h2>Animal Herido</h2>
          <ul class="mt-3">
            <li>No te acerques de golpe: deja que te huela primero.</li>
            <li>Envuelve suavemente la herida con una gasa limpia o paño.</li>
            <li>Inmoviliza al animal para evitar más daño.</li>
            <li>Traslada al veterinario más cercano cuanto antes.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="ratio ratio-16x9 reveal">
            <iframe
              src="https://www.youtube-nocookie.com/embed/rew6XeIZRsE?rel=0"
              title="Primeros auxilios para mascotas"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
    </section>


    <section id="agresivo" class="mb-5 reveal">
      <div class="row g-4 align-items-center flex-md-row-reverse">
        <div class="col-md-5">
          <i class="fa-solid fa-shield-cat fa-3x text-warning mb-3"></i>
          <h2>Animal Agresivo</h2>
          <ul class="mt-3">
            <li>Mantén distancia: no hagas movimientos bruscos.</li>
            <li>Usa objetos como barrera (toalla, chaqueta) para protegerte.</li>
            <li>Evita el contacto visual directo, puede interpretarse como amenaza.</li>
            <li>Contacta con bomberos o control animal si no puedes manejarlo.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="ratio ratio-16x9 reveal">
            <iframe
              src="https://www.youtube-nocookie.com/embed/U1lPRbzIUVE?rel=0"
              title="Cómo manejar animales agresivos"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
    </section>

    <section id="extraviado" class="mb-5 reveal">
      <div class="row g-4 align-items-center">
        <div class="col-md-5">
          <i class="fa-solid fa-map-location-dot fa-3x text-info mb-3"></i>
          <h2>Animal Extraviado</h2>
          <ul class="mt-3">
            <li>Acércate con calma y habla en tono suave.</li>
            <li>Ofrece agua y comida para ganarte su confianza.</li>
            <li>Revisa si lleva collar con datos de contacto.</li>
            <li>Publica foto y ubicación en redes y plataforma.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="ratio ratio-16x9 reveal">
            <iframe
              src="https://www.youtube-nocookie.com/embed/-IYPuUjU8DU?rel=0"
              title="Guía para ayudar a un animal perdido"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
    </section>

    <div class="text-center mt-5 reveal">
      <a href="index.php" class="btn btn-primary btn-lg">Volver al Inicio</a>
    </div>
  </main>

 
  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
</body>
</html>
