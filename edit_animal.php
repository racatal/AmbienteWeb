<?php
// edit_animal.php
session_start();
require 'conn.php';

// 1) Verificar sesión y parámetro id
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$userId  = $_SESSION['user_id'];
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
$id      = (int)$_GET['id'];

// 2) Leer datos actuales y verificar permisos
$stmt = $pdo->prepare("
    SELECT usuario_id, tipo, raza, color, tamanio, fecha_encontrado, lugar, foto
    FROM animales
    WHERE id = :id
      AND (usuario_id = :uid OR :isAdmin = 1)
");
$stmt->execute(['id'=>$id, 'uid'=>$userId, 'isAdmin'=>$isAdmin?1:0]);
$animal = $stmt->fetch();
if (!$animal) {
    // Ni es admin ni es propietario
    header('Location: index.php');
    exit;
}

// 3) Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo             = trim($_POST['tipo']            ?? '');
    $raza             = trim($_POST['raza']            ?? null);
    $color            = trim($_POST['color']           ?? null);
    $tamanio          = trim($_POST['tamanio']         ?? null);
    $fecha_encontrado = trim($_POST['fecha_encontrado'] ?? '');
    $lugar            = trim($_POST['lugar']           ?? null);
    $foto             = trim($_POST['foto']            ?? '');

    // Validaciones
    if ($tipo === '' || $fecha_encontrado === '') {
        $error = 'Los campos "Tipo" y "Fecha encontrado" son obligatorios.';
    } else {
        $sql = "
            UPDATE animales
            SET tipo             = :tipo,
                raza             = :raza,
                color            = :color,
                tamanio          = :tamanio,
                fecha_encontrado = :fecha,
                lugar            = :lugar,
                foto             = :foto
            WHERE id = :id
              AND (usuario_id = :uid OR :isAdmin = 1)
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'tipo'     => $tipo,
            'raza'     => $raza,
            'color'    => $color,
            'tamanio'  => $tamanio,
            'fecha'    => $fecha_encontrado,
            'lugar'    => $lugar,
            'foto'     => $foto,
            'id'       => $id,
            'uid'      => $userId,
            'isAdmin'  => $isAdmin?1:0
        ]);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Mascota #<?= $id ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'layout/nav.php'; ?>
  <div class="container my-5" style="max-width:600px;">
    <h2 class="mb-4">Editar Mascota #<?= $id ?></h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="tipo" class="form-label">Tipo *</label>
        <input name="tipo" id="tipo" required
               class="form-control"
               value="<?= htmlspecialchars($animal['tipo']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Raza</label>
        <input name="raza"
               class="form-control"
               value="<?= htmlspecialchars($animal['raza']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Color</label>
        <input name="color"
               class="form-control"
               value="<?= htmlspecialchars($animal['color']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Tamaño</label>
        <input name="tamanio"
               class="form-control"
               value="<?= htmlspecialchars($animal['tamanio']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Fecha encontrado *</label>
        <input type="date" name="fecha_encontrado" required
               class="form-control"
               value="<?= htmlspecialchars($animal['fecha_encontrado']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Lugar</label>
        <input name="lugar"
               class="form-control"
               value="<?= htmlspecialchars($animal['lugar']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">URL de imagen *</label>
        <input type="url" name="foto" required
               class="form-control"
               value="<?= htmlspecialchars($animal['foto']) ?>">
      </div>
      <button type="submit" class="btn btn-primary">Guardar cambios</button>
      <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>
