<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Donaciones – Pet Homeless</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link href="css/style.css" rel="stylesheet" />

  <script src="https://www.paypal.com/sdk/js?client-id=Aan74Fi1LInCPVdI950gerCHcF5rzZFxEpcpON1U0gkY0Ecj9J0CWt9oUfahWAJT3O9XM_oo-zYBQr9d&currency=USD"></script>
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <div class="container my-5">
    <div class="card mx-auto" style="max-width: 400px;">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">
          Dona a Perritos Callejeros
        </h5>

        <div class="mb-3">
          <label for="amount" class="form-label">Monto (USD)</label>
          <input
            type="number"
            id="amount"
            class="form-control"
            placeholder="Ej: 5"
            step="0.01"
            min="1"
            value="5"
          />
        </div>

        <div id="paypal-button-container"></div>
      </div>
    </div>
  </div>

    <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
  <script src="js/donaciones.js"></script>

</body>
</html>
