<?php
require_once 'auth.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: usuarioDashboard.php');
    exit;
}

require_once 'config/conn.php';

// Obtener animales con nombre del dueño
$stmt = $pdo->query("
    SELECT a.*, u.nombre AS dueño
    FROM animales a
    JOIN usuarios u ON a.usuario_id = u.id
    ORDER BY a.fecha_registro DESC
");

$animales = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
</head>
<body>
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?> (Admin)</h2>
    <a href="logout.php">Cerrar sesión</a>
    <h3>Animales registrados</h3>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Raza</th>
            <th>Color</th>
            <th>Dueño</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($animales as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['tipo']) ?></td>
            <td><?= htmlspecialchars($a['raza']) ?></td>
            <td><?= htmlspecialchars($a['color']) ?></td>
            <td><?= htmlspecialchars($a['dueño']) ?></td>
            <td><?= $a['fecha_encontrado'] ?></td>
            <td>
                <!-- Botones opcionales -->
                <a href="eliminarAnimal.php?id=<?= $a['id'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>