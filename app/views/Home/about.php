
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Acerca de nuestra pagina</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
   
</head>
<body>

 <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
        <h1>Acerca de Pet Homeless</h1>
    </div>
  </header>


  <main class="container my-5">
    <p class="lead">Pet Homeless es una plataforma dedicada a facilitar el registro y la búsqueda de animales perdidos. Nuestra misión es conectar dueños y mascotas, promoviendo un rescate responsable y adopciones éticas.</p>
    <section class="mt-4">
      <h2>Objetivos</h2>
      <ul>
        <li>Permitir a los usuarios reportar animales perdidos o encontrados.</li>
        <li>Ofrecer una galería intuitiva para consultar animales registrados.</li>
        <li>Fomentar la adopción si no se reclaman en un plazo establecido.</li>
        <li>Recibir feedback y sugerencias para mejorar el sistema.</li>
      </ul>
    </section>
    <section class="mt-4">
      <h2>Equipo</h2>
      <p>sobre este proyecto.</p>
    </section>
    <a href="index.php" class="btn btn-primary mt-4">Volver al Inicio</a>
  </main>

  <footer class="footer py-3 text-center">
    <div class="container">
      <small>&copy; <?= date('Y') ?> Pet Homeless</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>