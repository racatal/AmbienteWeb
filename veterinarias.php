<?php

session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Veterinarias Cercanas – Pet Homeless</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link href="css/style.css" rel="stylesheet" />
 
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  />
  <style>
    #map {
      height: 600px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
      <h1 class="display-4">Veterinarias Cercanas</h1>
      <p class="lead">Busca la veterinaria más cercana</p>
    </div>
  </header>

  <main class="container mb-5">
    <!-- Control del radio -->
    <div class="row mb-3">
      <div class="col-md-6 offset-md-3">
        <label for="radius" class="form-label">Radio de búsqueda:</label>
        <input type="range" class="form-range" id="radius" min="1" max="20" value="5">
        <div>
          <span id="radius-value" class="fw-bold">5</span> km
        </div>
        <button id="btn-search" class="btn btn-primary mt-2">Buscar veterinarias</button>
      </div>
    </div>


    <div id="map"></div>
  </main>

  <?php include 'layout/footer.php'; ?>


  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script src="js/vets.js"></script>

  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
</body>
</html>
