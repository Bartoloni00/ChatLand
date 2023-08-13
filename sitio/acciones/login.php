<?php
session_start();
require_once __DIR__ . '/../bootstrap/autoload.php';

$email = $_POST['email'];
$password = $_POST['password'];

try {
    if((new Auth)->iniciarSesion($email,$password)){
        $_SESSION['mensajeExito'] = 'Bienvenido nuevamente';
        header("Location: ../index.php?s=chats");
        exit;
    }
    $_SESSION['mensajeError'] = 'El email o la contraseña son incorrectos';
    $_SESSION['errorAutenticacion'] = $email;
    header("Location: ../index.php?s=login");
    exit;
} catch (Exception $error) {
    $_SESSION['mensajeError'] = 'Ocurrio un error inesperado. vuelve a intentar en unos minutos';
    header("Location: ../index.php?s=login");
    exit;
}
