<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>¡Gracias por tu donación!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <div class="container my-5 text-center">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
      <div class="card-body">
        <h2 class="card-title mb-3">¡Muchas gracias!</h2>
        <p class="card-text">
          Tu donación ayudará a dar comida y refugio a perritos de la calle.
        </p>
        <a href="donaciones.php" class="btn btn-primary mt-4">
          Volver a Donar
        </a>
      </div>
    </div>
  </div>

  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
</body>
</html>
