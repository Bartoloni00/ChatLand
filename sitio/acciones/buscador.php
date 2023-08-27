<?php
require_once __DIR__ . '/../bootstrap/autoload.php';
session_start();

$autenticado = (new Auth);
if (!$autenticado->estaAutenticado()) {
    $_SESSION['mensajeError'] = 'Se requiere haber iniciado sesion para realizar una busqueda';
    header('Location: ../index.php?s=login');
    exit;
}

$campo = $_POST['buscador'];
$busqueda = '%'.$campo.'%';

$button = $_POST['accion'];
if ($button == 'buscar') {
    try {
        $resultado = (new Buscador)->buscarPorUsername($busqueda);
        if (empty($resultado)) {
            $resultado = (new Buscador)->buscarPorEmail($busqueda);
        }
        $_SESSION['buscador'] = $resultado;
        header('Location: ../index.php?s=chats');
        exit;
    } catch (Exception $error) {
        $_SESSION['mensajeError'] = 'Algo salio mal al buscar un usuario';
        header('Location: ../index.php?s=chats');
        exit;
    }
} else if ($button == 'reiniciar'){
    try {
        $resultado = (new Usuarios)->todo();
        $_SESSION['buscador'] = $resultado;
        header('Location: ../index.php?s=chats');
        exit;
    } catch (Exception $error) {
        $_SESSION['mensajeError'] = 'Algo salio mal al reiniciar la busqueda de usuarios';
        header('Location: ../index.php?s=chats');
        exit;
    }
}
header('Location: ../index.php?s=login');
exit;