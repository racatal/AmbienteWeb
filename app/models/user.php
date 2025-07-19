<?php
require_once __DIR__ . '/../config/conn.php';

class user {
    public static function registrar($nombre, $correo, $contrasena) {
        global $pdo; // Asegúrate de que $pdo esté disponible
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (:nombre, :correo, :contrasena)");
        $stmt->execute([
            'nombre'     => $nombre,
            'correo'     => $correo,
            'contrasena' => $hash
        ]);
    }
}
