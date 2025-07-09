<?php
session_start();
require 'conn.php'; 

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $correo    = trim($_POST['correo'] ?? '');
    $contrasena= $_POST['contrasena'] ?? '';
    
    if ($nombre && $correo && $contrasena) {
     
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            'INSERT INTO usuarios (nombre, correo, contrasena) VALUES (:nombre, :correo, :contrasena)'
        );
        try {
            $stmt->execute([
                'nombre'    => $nombre,
                'correo'    => $correo,
                'contrasena'=> $hash
            ]);
        
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $error = 'El correo ya está registrado.';
        }
    } else {
        $error = 'Completa todos los campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrarse - Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

 <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
        <h1>Registrarse</h1>
    </div>
  </header>
  <div class="container mt-5" style="max-width: 400px;">
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>
      <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
      <a href="index.php" class="btn btn-secondary w-100">Volver al inicio</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>