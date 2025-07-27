<?php
session_start();
require 'conn.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($correo && $contrasena) {
        $stmt = $pdo->prepare('SELECT id, nombre, contrasena, rol FROM usuarios WHERE correo = :correo');
        $stmt->execute(['correo' => $correo]);
        $user = $stmt->fetch();
        $loginOk = false;
        if ($user) {
          
            if (password_verify($contrasena, $user['contrasena'])) {
                $loginOk = true;
            } 
           
            elseif (hash('sha256', $contrasena) === $user['contrasena']) {
               
                $newHash = password_hash($contrasena, PASSWORD_DEFAULT);
                $upd = $pdo->prepare('UPDATE usuarios SET contrasena = :h WHERE id = :id');
                $upd->execute(['h' => $newHash, 'id' => $user['id']]);
                $loginOk = true;
            }
        }
        if ($loginOk) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];
            header('Location: index.php');
            exit;
        }
        $error = 'Credenciales incorrectas.';
    } else {
        $error = 'Por favor ingresa correo y contraseña.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión - Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
        <h1>Iniciar Sesión</h1>
    </div>
  </header> 
  <div class="container mt-5" style="max-width:400px;">

    <?php if($error): ?>
      <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label" for="correo">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>
      <div class="mb-3">
        <label class="form-label" for="contrasena">Contraseña</label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>

      <a href="register.php" class="btn btn-secondary w-100">Registrarse</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'layout/footer.php'; ?>
</body>
</html>