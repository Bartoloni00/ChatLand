<?php
session_start();
require_once __DIR__ . '/../bootstrap/autoload.php';

$autenticado = (new Auth);
if (!$autenticado->estaAutenticado()) {
    $_SESSION['mensajeError'] = 'Se requiere haber iniciado sesion para acceder a este contenido';
    header('Location: ../index.php?s=login');
    exit;
}

$imagen = $_FILES['userImg'];
$username = $_POST['username'];
$email = $_POST['email'];

$errores = [];
if(empty($email)){
    $errores['email'] = 'Tu usuario debe poseer un email';
}
foreach ((new Usuarios) as $usuarioExistente) 
{
    if ($email == $usuarioExistente->getEmail() && $email != $usuarioExistente->getEmail()) 
    {
        $errores['email'] = 'Este email ya esta registrado';
    }
}
if(empty($email)){
    $errores['email'] = 'Tu usuario debe poseer un email';
}
if (empty($username)) {
    $errores['username'] = 'Debes tener un username asociado a tu cuenta';
}
foreach ((new Usuarios) as $usuarioExistente) 
{
    if ($username == $usuarioExistente->getUsername() && $username != $usuarioExistente->getUsername()) 
    {
        $errores['username'] = 'Este username ya esta registrado';
    }
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['oldData'] = $_POST;
    print_r($errores);
    // $_SESSION['mensajeError'] = 'datos no validos';
    // header('Location: ../index.php?s=profile');
    // exit;
    }

try { 
    $idUsuarioAutenticado = $autenticado->getUsuarios()->getIdUsuarios();
    try {
        $autenticado->getUsuarios()->editar($idUsuarioAutenticado, [
            'username' => $username,
            'email' => $email
        ]);
    } catch (Exception $error) {
        $_SESSION['mensajeError'] = 'Ocurrio un error al actualizar los datos '.$error;
        header('Location: ../index.php?s=profile');
        exit;
    }
    // try {
    //     (new Fotos)->agregarFoto($img, $idUsuarioAutenticado);
    // } catch (Exception $error) {
    //     $_SESSION['mensajeError'] = 'Ocurrio al subir la imagen';
    //     header('Location: ../index.php?s=profile');
    //     exit;
    // }
    $_SESSION['mensajeExito'] = 'Los datos fueron actualizados correctamente';
        header('Location: ../index.php?s=profile');
        exit;
} catch (Exception $error) {
    $_SESSION['mensajeError'] = 'Oh no, Ocurrio un error inesperado en la edicion de datos del usuario';
    header('Location: ../index.php?s=profile');
    exit;
}