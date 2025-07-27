<?php
// profile.php
session_start();
require 'conn.php';

// 1) Redirigir si no está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

$error   = '';
$success = '';

// 2) Traer datos del usuario
$stmt = $pdo->prepare("SELECT nombre, correo, contrasena FROM usuarios WHERE id = :uid");
$stmt->execute(['uid' => $userId]);
$user = $stmt->fetch();
if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// 3) Procesar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Campos básicos
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');

    // Campos de contraseña
    $passAct = trim($_POST['pass_actual']  ?? '');
    $passNew = trim($_POST['pass_nueva']   ?? '');
    $passCon = trim($_POST['pass_confirm'] ?? '');

    // Validar nombre y correo
    if ($nombre === '' || $correo === '') {
        $error = 'Nombre y correo son obligatorios.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'Correo no válido.';
    } else {
        // Si cambió el correo, verificar unicidad
        if ($correo !== $user['correo']) {
            $chk = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = :c AND id <> :uid");
            $chk->execute(['c'=>$correo,'uid'=>$userId]);
            if ($chk->fetchColumn() > 0) {
                $error = 'Ese correo ya está en uso.';
            }
        }
    }

    // 4) Contraseña: sólo validar si rellenó alguno de los tres campos
    if (!$error && ($passAct || $passNew || $passCon)) {
        // Debe rellenar los tres
        if (!$passAct || !$passNew || !$passCon) {
            $error = 'Para cambiar la contraseña debes rellenar los 3 campos.';
        } elseif (!password_verify($passAct, $user['contrasena'])) {
            $error = 'La contraseña actual no coincide.';
        } elseif (strlen($passNew) < 6) {
            $error = 'La nueva contraseña debe tener al menos 6 caracteres.';
        } elseif ($passNew !== $passCon) {
            $error = 'La nueva contraseña y su confirmación no coinciden.';
        } else {
            $hashToSave = password_hash($passNew, PASSWORD_DEFAULT);
        }
    }

    // 5) Si no hay error, actualizar
    if (!$error) {
        // Armar SET dinámico
        $sets = ['nombre = :n', 'correo = :c'];
        $params = ['n'=>$nombre, 'c'=>$correo, 'uid'=>$userId];
        if (isset($hashToSave)) {
            $sets[] = 'contrasena = :p';
            $params['p'] = $hashToSave;
        }
        $sql = "UPDATE usuarios SET " . implode(', ', $sets) . " WHERE id = :uid";
        $pdo->prepare($sql)->execute($params);

        // Refrescar sesión y datos
        $_SESSION['user_name'] = $nombre;
        $user['nombre'] = $nombre;
        $user['correo'] = $correo;
        $success = 'Perfil actualizado con éxito.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Perfil – Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>
  <div class="container my-5" style="max-width:600px;">
    <h2 class="mb-4">Mi Perfil</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post">
      <!-- Nombre -->
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo *</label>
        <input
          type="text"
          id="nombre"
          name="nombre"
          class="form-control"
          required
          value="<?= htmlspecialchars($user['nombre']) ?>"
        >
      </div>
      <!-- Correo -->
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico *</label>
        <input
          type="email"
          id="correo"
          name="correo"
          class="form-control"
          required
          value="<?= htmlspecialchars($user['correo']) ?>"
        >
      </div>
      <hr>
      <h5>Cambiar contraseña</h5>
      <p class="text-muted">Rellena estos campos sólo si deseas cambiar tu contraseña.</p>
      <div class="mb-3">
        <label for="pass_actual" class="form-label">Contraseña actual</label>
        <input
          type="password"
          id="pass_actual"
          name="pass_actual"
          class="form-control"
        >
      </div>
      <div class="mb-3">
        <label for="pass_nueva" class="form-label">Nueva contraseña</label>
        <input
          type="password"
          id="pass_nueva"
          name="pass_nueva"
          class="form-control"
        >
      </div>
      <div class="mb-3">
        <label for="pass_confirm" class="form-label">Confirmar nueva contraseña</label>
        <input
          type="password"
          id="pass_confirm"
          name="pass_confirm"
          class="form-control"
        >
      </div>

      <button type="submit" class="btn btn-primary">Guardar cambios</button>
      <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
    </form>
  </div>

    <?php include 'layout/footer.php'; ?>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  ></script>
</body>
</html>
