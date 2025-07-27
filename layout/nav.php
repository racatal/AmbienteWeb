<?php
  $current = basename($_SERVER['SCRIPT_NAME']); 
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="css/style.css" rel="stylesheet"/>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.php">Pet Homeless</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= $current==='index.php'    ? 'active' : '' ?>" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current==='about.php'    ? 'active' : '' ?>" href="about.php">Acerca</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current==='comments.php' ? 'active' : '' ?>" href="comments.php">Sugerencias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current==='contacto.php' ? 'active' : '' ?>" href="contacto.php">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current==='donaciones.php' ? 'active' : '' ?>" href="donaciones.php">Donaciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current==='veterinarias.php' ? 'active' : '' ?>" href="veterinarias.php">Veterinarias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current==='actuar.php' ? 'active' : '' ?>" href="actuar.php">Cómo Actuar</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="userMenu"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">
              <?= htmlspecialchars($_SESSION['user_name']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="user.php">Mis Reportes</a></li>
               <li><a class="dropdown-item" href="perfil.php">Mi Perfil</a></li>
              <?php if ($_SESSION['user_role']==='admin'): ?>
                <li><a class="dropdown-item" href="admin.php">Panel Admin</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?= $current==='login.php'    ? 'active' : '' ?>" href="login.php">Iniciar Sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current==='register.php' ? 'active' : '' ?>" href="register.php">Registrarse</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <script src="js/nav.js"></script>
</nav>
