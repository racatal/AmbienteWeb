<?php
session_start();
require 'conn.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) exit('ID inválido.');
$stmt = $pdo->prepare(
  'SELECT a.*, u.nombre AS reportado_por FROM animales a
   JOIN usuarios u ON a.usuario_id = u.id WHERE a.id = :id'
);
$stmt->execute(['id' => (int)$_GET['id']]);
$animal = $stmt->fetch() ?: exit('No encontrado');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalles - <?= htmlspecialchars($animal['tipo']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <a href="index.php" class="btn btn-outline-secondary mb-4">Volver</a>
    <div class="card shadow-lg">
      <img src="<?= htmlspecialchars($animal['foto']) ?>" class="card-img-top2" alt="">
      <div class="card-body">
        <h2 class="card-title"><?= htmlspecialchars($animal['tipo']) ?></h2>
        <ul class="list-unstyled">
          <li><strong>Raza:</strong> <?= htmlspecialchars($animal['raza'] ?? 'N/A') ?></li>
          <li><strong>Color:</strong> <?= htmlspecialchars($animal['color'] ?? 'N/A') ?></li>
          <li><strong>Tamaño:</strong> <?= htmlspecialchars($animal['tamanio'] ?? 'N/A') ?></li>
          <li><strong>Fecha encontrado:</strong> <?= htmlspecialchars($animal['fecha_encontrado']) ?></li>
          <li><strong>Lugar:</strong> <?= htmlspecialchars($animal['lugar'] ?? 'N/A') ?></li>
          <li><strong>Reportado por:</strong> <?= htmlspecialchars($animal['reportado_por']) ?></li>
          <li><strong>Registrado el:</strong> <?= htmlspecialchars($animal['fecha_registro']) ?></li>
        </ul>
        <?php if ($animal['reclamado']): ?>
          <span class="badge bg-success">Reclamado</span>
        <?php else: ?>
          <span class="badge bg-warning text-dark">No reclamado</span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>