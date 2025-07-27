<?php

session_start();
require 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare(
    'SELECT id, tipo, raza, color, tamanio, fecha_encontrado, lugar, reclamado 
     FROM animales 
     WHERE usuario_id = :uid 
     ORDER BY fecha_registro DESC'
);
$stmt->execute(['uid' => $userId]);
$misAnimales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Panel – Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <div class="container my-5">
    <h2 class="mb-4">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>


    <button
      class="btn btn-success mb-3"
      data-bs-toggle="collapse"
      data-bs-target="#addForm"
    >Reportar una Mascota</button>

    <div class="collapse mb-4" id="addForm">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Agregar nueva mascota</h5>
          <form id="formAddAnimal">
            <div class="row g-2">
              <div class="col-md-2">
                <input type="text" name="tipo" class="form-control" placeholder="Tipo" required>
              </div>
              <div class="col-md-2">
                <input type="text" name="raza" class="form-control" placeholder="Raza">
              </div>
              <div class="col-md-2">
                <input type="text" name="color" class="form-control" placeholder="Color">
              </div>
              <div class="col-md-2">
                <select name="tamanio" class="form-select">
                  <option value="">Tamaño</option>
                  <option value="pequeño">Pequeño</option>
                  <option value="mediano">Mediano</option>
                  <option value="grande">Grande</option>
                </select>
              </div>
              <div class="col-md-2">
                <input type="date" name="fecha_encontrado" class="form-control" required>
              </div>
              <div class="col-md-2">
                <input type="text" name="lugar" class="form-control" placeholder="Lugar">
              </div>
            </div>
            <div class="row g-2 mt-2">
              <div class="col-12">
                <input type="url" name="foto" class="form-control" placeholder="URL de imagen" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Guardar Mascota</button>
          </form>
        </div>
      </div>
    </div>


    <?php if (empty($misAnimales)): ?>
      <p>No has reportado ningún animal aún.</p>
    <?php else: ?>
      <div class="table-responsive">
        <p>Total reportados: <span id="userCount"><?= count($misAnimales) ?></span></p>
        <table class="table table-striped">
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
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="userTableBody">
            <?php foreach ($misAnimales as $a): ?>
            <tr data-id="<?= $a['id'] ?>">
              <td><?= $a['id'] ?></td>
              <td><?= htmlspecialchars($a['tipo']) ?></td>
              <td><?= htmlspecialchars($a['raza'] ?? '') ?></td>
              <td><?= htmlspecialchars($a['color'] ?? '') ?></td>
              <td><?= htmlspecialchars($a['tamanio'] ?? '') ?></td>
              <td><?= htmlspecialchars($a['fecha_encontrado']) ?></td>
              <td><?= htmlspecialchars($a['lugar'] ?? '') ?></td>
              <td><?= $a['reclamado'] ? 'Sí' : 'No' ?></td>
              <td>
                <a href="edit_animal.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                <a href="delete_animal.php?id=<?= $a['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar registro?');"
                >Eliminar</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>

 
  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
  <script src="js/user_add.js"></script>
</body>
</html>
