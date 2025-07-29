<?php
session_start();
header('Content-Type: application/json');

require 'conn.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Lee JSON de la petición
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id']) || !is_numeric($input['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID inválido']);
    exit;
}

$id = (int)$input['id'];

try {
    //Marca como reclamado
    $stmt = $pdo->prepare(
        'UPDATE animales
         SET reclamado = 1
         WHERE id = :id AND reclamado = 0'
    );
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
        // O bien ya estaba reclamado, o el ID no existe
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Mascota no encontrada o ya reclamada']);
    } else {
        echo json_encode(['success' => true]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al actualizar la base de datos']);
}
