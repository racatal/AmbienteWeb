<?php

session_start();
require 'conn.php';

// Consulta animales perdidos
$stmt = $pdo->query("
  SELECT id, usuario_id, tipo, raza, color, tamanio, fecha_encontrado, lugar, foto 
  FROM animales 
  WHERE reclamado = 0 
  ORDER BY fecha_registro DESC
");
$animales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Homeless</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <link href="/pethomeless/css/style.css" rel="stylesheet">

</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
      <h1 class="display-4">Animales Perdidos</h1>
      <p class="lead">
        Total reportados:
        <span id="totalCount"><?= count($animales) ?></span>
      </p>

      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Usuario logueado: despliega el formulario -->
        <a
          href="#addForm"
          class="btn btn-primary mt-3 btn-add"
          data-bs-toggle="collapse"
        >Agregar Mascota</a>
      <?php else: ?>
        <!-- No logueado: redirige a login -->
        <button
          class="btn btn-primary mt-3 btn-add-redirect"
        >Agregar Mascota</button>
      <?php endif; ?>
    </div>
  </header>

  <main class="container mb-5">
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="collapse mb-4" id="addForm">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Reportar nueva mascota</h5>
            <form id="formAddPet">
              <div class="row g-2">
                <div class="col-md-2">
                  <input
                    type="text" name="tipo"
                    class="form-control"
                    placeholder="Tipo"
                    required
                  >
                </div>
                <div class="col-md-2">
                  <input
                    type="text" name="raza"
                    class="form-control"
                    placeholder="Raza"
                  >
                </div>
                <div class="col-md-2">
                  <input
                    type="text" name="color"
                    class="form-control"
                    placeholder="Color"
                  >
                </div>
                <div class="col-md-2">
                  <input
                    type="text" name="tamanio"
                    class="form-control"
                    placeholder="Tamaño"
                  >
                </div>
                <div class="col-md-2">
                  <input
                    type="date" name="fecha_encontrado"
                    class="form-control"
                    required
                  >
                </div>
                <div class="col-md-2">
                  <input
                    type="text" name="lugar"
                    class="form-control"
                    placeholder="Lugar"
                  >
                </div>
              </div>
              <div class="row g-2 mt-2">
                <div class="col-12">
                  <input
                    type="url" name="foto"
                    class="form-control"
                    placeholder="URL de imagen"
                    required
                  >
                </div>
              </div>
              <button
                type="submit"
                class="btn btn-primary mt-3"
              >
                Agregar mascota
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row g-4" id="gallery">
      <?php foreach ($animales as $a): ?>
        <div
          class="col-sm-6 col-md-4 col-lg-3 pet-card"
          data-id="<?= $a['id'] ?>"
        >
          <div class="card h-100 shadow-sm">
            <img
              src="<?= htmlspecialchars($a['foto']) ?>"
              class="card-img-top"
              alt="<?= htmlspecialchars($a['tipo']) ?>"
            >
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($a['tipo']) ?></h5>
              <p class="card-text mb-4">
                Raza:     <?= htmlspecialchars($a['raza'] ?: 'N/A') ?><br>
                Color:    <?= htmlspecialchars($a['color'] ?: 'N/A') ?><br>
                Tamaño:   <?= htmlspecialchars($a['tamanio'] ?: 'N/A') ?><br>
                Fecha:    <?= htmlspecialchars($a['fecha_encontrado']) ?><br>
                Lugar:    <?= htmlspecialchars($a['lugar'] ?: 'N/A') ?>
              </p>
              <div class="mt-auto d-grid gap-2">
                <a
                  href="detalle.php?id=<?= $a['id'] ?>"
                  class="btn btn-secondary"
                >
                  Detalles
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                  <button class="btn btn-success btn-reclaim">
                    Reclamar
                  </button>
                <?php else: ?>
                  <button class="btn btn-success btn-reclaim-redirect">
                    Reclamar
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>

  <?php include 'layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
  <script src="js/addmas.js"></script>
  <script src="js/reclamo.js"></script>
  <script src="js/redirect.js"></script>
</body>
</html>
