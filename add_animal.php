<?php
session_start();
require 'conn.php';

//anadir animales 

if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    exit;
}
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success'=>false,'error'=>'No autorizado']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Payload inválido']);
    exit;
}

$tipo             = trim($input['tipo'] ?? '');
$raza             = trim($input['raza'] ?? null);
$color            = trim($input['color'] ?? null);
$tamanio          = trim($input['tamanio'] ?? null);
$fecha_encontrado = trim($input['fecha_encontrado'] ?? '');
$lugar            = trim($input['lugar'] ?? null);
$foto             = trim($input['foto'] ?? '');

if ($tipo==='' || $fecha_encontrado==='' || $foto==='') {
    http_response_code(422);
    echo json_encode([
      'success'=>false,
      'error'=>'Campos Tipo, Fecha e Imagen obligatorios'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
      INSERT INTO animales
      (usuario_id,tipo,raza,color,tamanio,fecha_encontrado,lugar,foto)
      VALUES
      (:uid,:tipo,:raza,:color,:tamanio,:fecha,:lugar,:foto)
    ");
    $stmt->execute([
      'uid'    => $_SESSION['user_id'],
      'tipo'   => $tipo,
      'raza'   => $raza,
      'color'  => $color,
      'tamanio'=> $tamanio,
      'fecha'  => $fecha_encontrado,
      'lugar'  => $lugar,
      'foto'   => $foto
    ]);
    $lastId = $pdo->lastInsertId();
    echo json_encode([
      'success'=>true,
      'animal'=>[
        'id'               => (int)$lastId,
        'tipo'             => $tipo,
        'raza'             => $raza,
        'color'            => $color,
        'tamanio'          => $tamanio,
        'fecha_encontrado' => $fecha_encontrado,
        'lugar'            => $lugar,
        'foto'             => $foto
      ]
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Error en base de datos']);
}
