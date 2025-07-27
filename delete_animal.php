<?php
// delete_animal.php
session_start();
require 'conn.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId  = $_SESSION['user_id'];
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';

// Validar id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: user.php');
    exit;
}
$id = (int)$_GET['id'];

// Borrar sólo si es propietario o admin
$stmt = $pdo->prepare("
    DELETE FROM animales
    WHERE id = :id
      AND (usuario_id = :uid OR :isAdmin = 1)
");
$stmt->execute([
    'id'      => $id,
    'uid'     => $userId,
    'isAdmin' => $isAdmin?1:0
]);

header('Location: user.php');
exit;
