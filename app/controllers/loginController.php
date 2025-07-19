<?php
session_start();
require_once __DIR__ . '/../models/userLogin.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($correo && $contrasena) {
        $user = Usuario::login($correo, $contrasena);
        if ($user) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];

            header('Location: ../../index.php');
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
        }
    } else {
        $error = 'Por favor ingresa correo y contraseña.';
    }
}

require_once __DIR__ . 'login.php';
