<?php
require_once 'auth.php';

if ($_SESSION['user_role'] !== 'usuario') {
    header('Location: adminDashboard.php');
    exit;
}

require_once 'config/conn.php';

$idUsuario = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM animales WHERE usuario_id = :id ORDER BY fecha_registro DESC");
$stmt->execute(['id' => $idUsuario]);
$animales = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Usuario</title>
</head>
<body>
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?> (Usuario)</h2>
    <a href="logout.php">Cerrar sesión</a>
    <h3>Mis animales registrados</h3>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Raza</th>
            <th>Color</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($animales as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['tipo']) ?></td>
            <td><?= htmlspecialchars($a['raza']) ?></td>
            <td><?= htmlspecialchars($a['color']) ?></td>
            <td><?= $a['fecha_encontrado'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
