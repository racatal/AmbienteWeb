<?php
if (!isset($error)) {
    $error = '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrarse - Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />

  </head>
<body>

  <?php include __DIR__ . '/layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container"><h1>Registrarse</h1></div>
  </header>

  <div class="container mt-5" style="max-width: 400px;">
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required />
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required />
      </div>

      <div class="mb-3 password-wrapper">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input
          type="password"
          class="form-control"
          id="contrasena"
          name="contrasena"
          required
        />
      </div>

      <div class="mb-3 password-wrapper">
        <label for="contrasena2" class="form-label">Repetir contraseña</label>
        <input
          type="password"
          class="form-control"
          id="contrasena2"
          name="contrasena2"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
      <a href="/index.php" class="btn btn-secondary w-100 mt-2">Volver al inicio</a>
    </form>
  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      if (input.type === 'password') {
        input.type = 'text';
      } else {
        input.type = 'password';
      }
    }
  </script>

</body>
</html>