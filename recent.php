<?php
require 'conn.php';
header('Content-Type: application/json');
$stmt = $pdo->query("
  SELECT tipo, CONCAT(tipo, ' - ', raza, ' (', color, ')') AS detalle,
         u.nombre AS usuario, fecha_registro AS fecha
  FROM animales a
  JOIN usuarios u ON a.usuario_id = u.id
  ORDER BY fecha_registro DESC
  LIMIT 5
");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
