<?php
session_start();
require_once __DIR__ . '/../bootstrap/autoload.php';

$id_chat = $_POST['chat'];
$contenido = $_POST['mensaje'];


try {
    $id_usuario = (new Auth)->getUsuarios()->getIdUsuarios();
    $tiempo_de_envio = (new Modelo)->obtenerFecha();
    (new Mensaje)->crearMensaje([
            'contenido'=>$contenido,
            'tiempo_de_envio'=>$tiempo_de_envio,
            'fk_usuarios'=>$id_usuario,
            'fk_chat'=>$id_chat
    ]);
    $_SESSION['mensajeExito'] = 'Has enviado un mensaje';
    header('Location: ../index.php?s=chats&ss=chat&id='.$id_chat);
    exit;
} catch (\Exception $error) {
    $_SESSION['mensajeError'] = 'Oh no, Ocurrio un error inesperado en el envio del mensaje'.$error;
    header('Location: ../index.php?s=chats&=sschat&id='.$id_chat);
    exit;
}