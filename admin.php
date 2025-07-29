<?php
session_start();
require 'conn.php';

// Verifica que sea admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Ver errores de BD en desarrollo
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Borra animal si viene por GET
if (isset($_GET['delete_animal']) && is_numeric($_GET['delete_animal'])) {
    $pdo->prepare("DELETE FROM animales WHERE id = :id")
        ->execute(['id' => (int)$_GET['delete_animal']]);
    header('Location: admin.php');
    exit;
}

//Borra usuario si viene por GET (sin permitir que se borre a sí mismo)
if (isset($_GET['delete_user']) && is_numeric($_GET['delete_user'])) {
    $delId = (int)$_GET['delete_user'];
    if ($delId !== $_SESSION['user_id']) {
        $pdo->prepare("DELETE FROM usuarios WHERE id = :id")
            ->execute(['id' => $delId]);
    }
    header('Location: admin.php');
    exit;
}

// Obtiene todos los animales
$allAnimals = $pdo->query("
    SELECT a.id, a.tipo, a.raza, a.color, a.tamanio,
           a.fecha_encontrado, a.lugar, a.reclamado,
           u.nombre AS reportado_por
      FROM animales a
      JOIN usuarios u ON a.usuario_id = u.id
     ORDER BY a.id DESC
")->fetchAll();

//Obtiene todos los usuarios
$allUsers = $pdo->query("
    SELECT id, nombre, correo
      FROM usuarios
     ORDER BY id DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Admin – Pet Homeless</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <div class="container my-5">
    <h1 class="mb-4">Panel de Administrador</h1>

    <!--Animales -->
    <h2>Animales Reportados</h2>
    <div class="table-responsive mb-5">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Raza</th>
            <th>Color</th>
            <th>Tamaño</th>
            <th>Fecha</th>
            <th>Lugar</th>
            <th>Reclamado</th>
            <th>Reportado por</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($allAnimals as $a): ?>
            <tr>
              <td><?= $a['id'] ?></td>
              <td><?= htmlspecialchars($a['tipo']) ?></td>
              <td><?= htmlspecialchars($a['raza']) ?></td>
              <td><?= htmlspecialchars($a['color']) ?></td>
              <td><?= htmlspecialchars($a['tamanio']) ?></td>
              <td><?= htmlspecialchars($a['fecha_encontrado']) ?></td>
              <td><?= htmlspecialchars($a['lugar']) ?></td>
              <td><?= $a['reclamado'] ? 'Sí' : 'No' ?></td>
              <td><?= htmlspecialchars($a['reportado_por']) ?></td>
              <td>
                <a href="edit_animal.php?id=<?= $a['id'] ?>"
                   class="btn btn-sm btn-primary">Editar</a>
                <a href="admin.php?delete_animal=<?= $a['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este animal?');"
                >Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Usuarios -->
    <h2>Usuarios Registrados</h2>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($allUsers as $u): ?>
            <tr>
              <td><?= $u['id'] ?></td>
              <td><?= htmlspecialchars($u['nombre']) ?></td>
              <td><?= htmlspecialchars($u['correo']) ?></td>
              <td>
                <a href="admin_edit_user.php?id=<?= $u['id'] ?>"
                   class="btn btn-sm btn-primary">Editar</a>
                <a href="admin.php?delete_user=<?= $u['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este usuario?');"
                >Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <a href="index.php" class="btn btn-secondary mt-4">Volver al inicio</a>
  </div>
   <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
</body>
</html>
