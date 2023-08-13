<?php
session_start();
require_once __DIR__ . '/../bootstrap/autoload.php';

$id_usuario1 = $_POST['id_usuario1'];
$id_usuarioCreador = (new Auth)->getUsuarios()->getIdUsuarios();

try {
    (new Chat)->crearConversacion($id_usuario1,$id_usuarioCreador);
    $usuariosModel = new Usuarios();
    $usuario1Data = $usuariosModel->porId($id_usuario1);
    $usuario2Data = $usuariosModel->porId($id_usuarioCreador);

    $usuario1 = $usuario1Data->getUsername() ?? $usuario1Data->getEmail();
    $usuario2 = $usuario2Data->getUsername() ?? $usuario2Data->getEmail();

    $_SESSION['mensajeExito'] = 'se ha creado una conversacion entre '. $usuario1 . ' y ' . $usuario2;
    header('Location: ../index.php?s=chats');
    exit;
} catch (\Exception $error) {
     $_SESSION['mensajeError'] = 'Ocurrio un error inesperado intente en unos minutos'. $error;
    header('Location: ../index.php?s=chats');
    exit;
}