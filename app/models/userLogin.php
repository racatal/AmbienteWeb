<?php
require_once __DIR__ . '/../../config/conn.php'; // Ajusta la ruta según sea necesario

class Usuario {
    public static function login($correo, $contrasena) {
        global $pdo;

        $stmt = $pdo->prepare('SELECT id, nombre, contrasena, rol FROM usuarios WHERE correo = :correo');
        $stmt->execute(['correo' => $correo]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        if (password_verify($contrasena, $user['contrasena'])) {
            return $user;
        } elseif (hash('sha256', $contrasena) === $user['contrasena']) {
            // Actualizar hash a password_hash
            $newHash = password_hash($contrasena, PASSWORD_DEFAULT);
            $upd = $pdo->prepare('UPDATE usuarios SET contrasena = :hash WHERE id = :id');
            $upd->execute(['hash' => $newHash, 'id' => $user['id']]);
            return $user;
        }

        return false;
    }

    public static function registrar($nombre, $correo, $contrasena) {
        global $pdo;
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            'INSERT INTO usuarios (nombre, correo, contrasena) VALUES (:nombre, :correo, :contrasena)'
        );
        return $stmt->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'contrasena' => $hash
        ]);
    }
}
