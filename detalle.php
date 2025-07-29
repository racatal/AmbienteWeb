<?php

session_start();
require 'conn.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    exit('ID inválido.');
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
  SELECT a.*, u.nombre AS reportado_por 
  FROM animales a
  JOIN usuarios u ON a.usuario_id = u.id
  WHERE a.id = :id
");
$stmt->execute(['id' => $id]);
$animal = $stmt->fetch();

if (!$animal) {
    exit('Animal no encontrado.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalles – <?= htmlspecialchars($animal['tipo']) ?></title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <div class="container my-5">
    <a href="index.php" class="btn btn-outline-secondary mb-4">Volver</a>

    <div class="row gx-5 align-items-start">

      <div class="col-md-6">
        <img
          src="<?= htmlspecialchars($animal['foto']) ?>"
          class="img-fluid rounded"
          alt="<?= htmlspecialchars($animal['tipo']) ?>"
        >
      </div>
      <div class="col-md-6">
        <h2 class="mb-3"><?= htmlspecialchars($animal['tipo']) ?></h2>
        <ul class="list-unstyled mb-4">
          <li><strong>Raza:</strong> <?= htmlspecialchars($animal['raza'] ?? 'N/A') ?></li>
          <li><strong>Color:</strong> <?= htmlspecialchars($animal['color'] ?? 'N/A') ?></li>
          <li><strong>Tamaño:</strong> <?= htmlspecialchars($animal['tamanio'] ?? 'N/A') ?></li>
          <li><strong>Fecha encontrado:</strong> <?= htmlspecialchars($animal['fecha_encontrado']) ?></li>
          <li><strong>Lugar:</strong> <?= htmlspecialchars($animal['lugar'] ?? 'N/A') ?></li>
          <li><strong>Reportado por:</strong> <?= htmlspecialchars($animal['reportado_por']) ?></li>
          <li><strong>Registrado el:</strong> <?= htmlspecialchars($animal['fecha_registro']) ?></li>
        </ul>

        <div class="d-flex gap-2">
          <?php if (isset($_SESSION['user_id'])): ?>
            <button class="btn btn-success btn-reclaim">
              Reclamar
            </button>
          <?php else: ?>
            <button class="btn btn-success btn-reclaim-redirect">
              Reclamar
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script src="js/detalle.js"></script>
  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src="js/actuar.js"></script>
</body>
</html>
