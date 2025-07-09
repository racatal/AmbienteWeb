<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare(
    'SELECT id, tipo, raza, color, fecha_encontrado, reclamado FROM animales WHERE usuario_id = :uid ORDER BY fecha_registro DESC'
);
$stmt->execute(['uid' => $userId]);
$misAnimales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Panel - Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <h2 class="mb-4">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
    <a href="add_animal.php" class="btn btn-success mb-3">Reporte un Animal</a>
    <?php if (empty($misAnimales)): ?>
      <p>No has reportado ningún animal aún.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tipo</th>
              <th>Raza</th>
              <th>Color</th>
              <th>Fecha</th>
              <th>Reclamado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($misAnimales as $a): ?>
            <tr>
              <td><?= $a['id'] ?></td>
              <td><?= htmlspecialchars($a['tipo']) ?></td>
              <td><?= htmlspecialchars($a['raza'] ?? '') ?></td>
              <td><?= htmlspecialchars($a['color'] ?? '') ?></td>
              <td><?= htmlspecialchars($a['fecha_encontrado']) ?></td>
              <td><?= $a['reclamado'] ? 'Sí' : 'No' ?></td>
              <td>
                <a href="edit_animal.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                <a href="delete_animal.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-outline-secondary">Volver al Inicio</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>