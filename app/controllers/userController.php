<?php
session_start();
require_once __DIR__ . '/../models/user.php'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = trim($_POST['nombre'] ?? '');
    $correo     = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($nombre && $correo && $contrasena) {
        try {
            user::registrar($nombre, $correo, $contrasena); 
            header('Location: /login.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = 'El correo ya está registrado.';
            } else {
                $error = 'Error inesperado al registrar.';
            }
        }
    } else {
        $error = 'Completa todos los campos.';
    }
}

require __DIR__ . '/../views/Home/registro.php';
