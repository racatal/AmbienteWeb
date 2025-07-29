<?php
session_start();
require 'conn.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    exit;
}
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success'=>false,'error'=>'No autorizado']);
    exit;
}

// Lee JSON de la petición
$input = json_decode(file_get_contents('php://input'), true);
$id    = isset($input['id']) && is_numeric($input['id'])
         ? (int)$input['id']
         : 0;
if (!$id) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'ID inválido']);
    exit;
}

try {
     //Marca como reclamado
    $stmt = $pdo->prepare("
      UPDATE animales
      SET reclamado = 1
      WHERE id = :id
    ");
    $stmt->execute(['id'=>$id]);
    if ($stmt->rowCount()===0) {
     // O bien ya estaba reclamado, o el ID no existe
        http_response_code(404);
        echo json_encode(['success'=>false,'error'=>'No encontrado o ya reclamado']);
    } else {
        echo json_encode(['success'=>true]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Error en base de datos']);
}
