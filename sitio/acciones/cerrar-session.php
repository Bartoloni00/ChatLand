<?php
session_start();
require_once __DIR__ . '/../clases/auth/Auth.php';

if(!(new Auth())->estaAutenticado()){
    $_SESSION['mensajeError'] = 'No existe una session abierta';
    header('Location : ../index.php?s=home');
    exit;
}

try {
    (new Auth())->cerrarSesion();

    $_SESSION['mesanejExito'] = 'La session se cerro exitosamente';
    header('Location: ../index.php?s=login');
    exit;
} catch (Exception $error) {
    $_SESSION['mesanejError'] = 'Ocurrio un error inesperado intente en unos minutos';
    header('Location: ../index.php?s=chats');
    exit;
}