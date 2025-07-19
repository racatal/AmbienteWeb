<?php
session_start();
require_once __DIR__ . '/config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && !empty($_POST['autor'])
    && !empty($_POST['calificacion'])
    && !empty($_POST['contenido'])) {
    $stmt = $pdo->prepare(
        'INSERT INTO resena (autor, contenido, calificacion, fecha) VALUES (:autor, :contenido, :calificacion, NOW())'
    );
    $stmt->execute([
        'autor'        => trim($_POST['autor']),
        'contenido'    => trim($_POST['contenido']),
        'calificacion' => (int) $_POST['calificacion']
    ]);
    header('Location: comments.php');
    exit;
}


$stmt = $pdo->query(
    'SELECT id, autor, contenido, calificacion, fecha FROM resena ORDER BY fecha DESC'
);
$resenas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reseñas de Nuestros Clientes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
 
  <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
      <h1 class="display-4">Comentarios</h1>
      <p class="lead">Di tu opinion para mejorar</p>
    </div>
  </header>


<div class="comment-card mx-auto" style="max-width: 1000px;">
    <div class="card-header">
        <h2>Ayudanos a mejorar</h2>
        </div>
    <div class="card-body">
   <div class="comment-form-container">
    <form action="comments.php" method="POST" class="needs-validation" novalidate>
      <div class="row justify-content-center">
        <div class="col-md-4">
          <input type="text" class="form-control" name="autor" placeholder="Tu nombre" required>
        </div>


        <div class="col-md-3">
          <select class="form-select" name="calificacion" required>
            <option value="" disabled selected>Calificación</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?> ★</option>
            <?php endfor; ?>
          </select>

        </div>
<div class="row justify-content-center">
        <div class="col-md-8">
          <textarea class="form-control" name="contenido" rows="3" placeholder="Tu comentario..." required></textarea>
       
        </div>  


        <div class="col-md-4">
          <button type="submit" class="btn btn-primary w-50">
            Publicar
          </button>
</div>
        </div>
      </div>
    </form>

 </div>
        <?php if (empty($resenas)): ?>
         <p class="text-center">Aún no hay reseñas.</p>
                <?php else: ?>
                    <div class="reviews-list">
                        <?php foreach ($resenas as $resena): ?>
                            <div class="card mb-3 product-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title"><?= htmlspecialchars($resena['autor'] ?? 'Anónimo') ?></h5>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($resena['fecha'])) ?></small>
                                    </div>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($resena['contenido'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
    

    <?php include 'layout/footer.php'; ?>

                        
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>