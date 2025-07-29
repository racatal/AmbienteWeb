<?php
session_start();
require 'conn.php';

// Verifica que sea admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

//Verificar parámetro id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: admin.php');
    exit;
}
$id = (int)$_GET['id'];

//Lee datos del usuario
$stmt = $pdo->prepare("SELECT id, nombre, correo FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();
if (!$user) {
    header('Location: admin.php');
    exit;
}

$error = '';
// Procesar form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');

    // Validaciones básicas
    if ($nombre === '' || $correo === '') {
        $error = 'Los campos "Nombre" y "Correo" son obligatorios.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo no tiene un formato válido.';
    } else {
        // Actualizar usuario
        $update = $pdo->prepare("
            UPDATE usuarios
               SET nombre = :nombre,
                   correo = :correo
             WHERE id     = :id
        ");
        $update->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'id'     => $id
        ]);

        header('Location: admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Usuario #<?= htmlspecialchars($user['id']) ?></title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <div class="container my-5" style="max-width: 600px;">
    <h2 class="mb-4">Editar Usuario #<?= htmlspecialchars($user['id']) ?></h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre *</label>
        <input
          type="text"
          id="nombre"
          name="nombre"
          class="form-control"
          required
          value="<?= htmlspecialchars($_POST['nombre'] ?? $user['nombre']) ?>"
        >
      </div>
      <div class="mb-3">
        <label for="correo" class="form-label">Correo *</label>
        <input
          type="email"
          id="correo"
          name="correo"
          class="form-control"
          required
          value="<?= htmlspecialchars($_POST['correo'] ?? $user['correo']) ?>"
        >
      </div>

      <button type="submit" class="btn btn-primary">Guardar cambios</button>
      <a href="admin.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>

  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
</body>
</html>
