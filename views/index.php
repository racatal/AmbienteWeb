<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Petology - Inicio</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Petology</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">Acerca</a></li>
        <li class="nav-item"><a class="nav-link" href="comments.php">Sugerencias</a></li>
      </ul>
      <ul class="navbar-nav">
        <?php if(isset($_SESSION['user_id'])): ?>
          <?php if($_SESSION['role']==='admin'): ?>
            <li class="nav-item"><a class="nav-link" href="admin_panel.php">Panel Admin</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="user_panel.php">Mi Panel</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-5">
  <div class="row">
    <div class="col-12 text-center mb-4">
      <h1>Bienvenidos a Petology</h1>
      <p class="lead">Consulta e inscribe animales perdidos, y facilítale una adopción ética.</p>
    </div>
  </div>
  <div class="row">
    <?php
    require 'config.php';
    $stmt = $pdo->query("SELECT id, tipo, raza, color, foto_url FROM animales WHERE reclamado=0 ORDER BY fecha_registro DESC");
    while($a=$stmt->fetch()): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="uploads/<?= htmlspecialchars($a['foto_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($a['tipo']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($a['tipo']) ?></h5>
            <p class="card-text">Raza: <?= htmlspecialchars($a['raza']) ?><br>Color: <?= htmlspecialchars($a['color']) ?></p>
            <a href="detalle.php?id=<?= $a['id'] ?>" class="btn btn-primary">Ver Detalles</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<footer class="bg-light text-center py-4">
  <div class="container">
    <p class="mb-1">&copy; <?= date('Y') ?> Petology - Todos los derechos reservados.</p>
    <p><a href="contact.php" class="text-decoration-none">Contáctanos</a></p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
