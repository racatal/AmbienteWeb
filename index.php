<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Redirigir según el rol
if ($_SESSION['user_role'] === 'admin') {
    header('Location: adminDashboard.php');
    exit;
} elseif ($_SESSION['user_role'] === 'usuario') {
    header('Location: usuarioDashboard.php');
    exit;
} else {

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Homeless</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.php">Pet Homeless</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">Acerca</a></li>
          <li class="nav-item"><a class="nav-link" href="comments.php">Sugerencias</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contacto</a></li>
        </ul>
        <ul class="navbar-nav">
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($_SESSION['user_name']) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="user.php">Mi Panel</a></li>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                  <li><a class="dropdown-item" href="admin.php">Panel Admin</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
            <li class="nav-item"><a class="nav-link" href="registro.php">Registrarse</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>


  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
      <h1 class="display-4">Animales Perdidos</h1>
      <p class="lead">Inscríbelos y encuentra a sus dueños o dales un hogar seguro</p>
    </div>
  </header>

  <main class="container mb-5">
    <div class="row g-4">
      <?php foreach ($animales as $a): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm">
          <img src="<?= htmlspecialchars($a['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($a['tipo']) ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($a['tipo']) ?></h5>
            <p class="card-text mb-4">Raza: <?= htmlspecialchars($a['raza'] ?? 'N/A') ?><br>Color: <?= htmlspecialchars($a['color'] ?? 'N/A') ?></p>
            <a href="detalle.php?id=<?= $a['id'] ?>" class="btn btn-primary w-100">Detalles</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </main>

   <?php include 'layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
