<?php
session_start();
require_once __DIR__ . '/../bootstrap/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

use Bartoloni00\Auth\Auth;
use Bartoloni00\Modelos\Usuarios;
use Bartoloni00\Modelos\Fotos;

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

    if (!empty($imagen['tmp_name'])) {
        $nombreImagen = date('YmdHis').'_'.$imagen['name'];
        $imagenEditada = Image::make($imagen['tmp_name']);//abro la imagen para luego editarla
        $imagenEditada->fit(200,200);//recorto y redimenciono la imagen
        $imagenEditada->save(__DIR__.'/../assets/users/'.$nombreImagen);//guardo la imagen

        $nombreImagenMobile = 'Mobile'.$nombreImagen;
        $imagenEditadaMobile = Image::make($imagen['tmp_name']);
        $imagenEditadaMobile->fit(50,50);
        $imagenEditadaMobile->save(__DIR__.'/../assets/users/mobile/'.$nombreImagenMobile);
        $imagen = $nombreImagen;//asigno el nombre de la imagen para que sea guardado en la BD
    }else{
        $imagen = null;
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
    try {
        $fotoClass = (new Fotos);
        if ($imagen !== null) {
            if($fotoClass->usuarioTieneFoto($idUsuarioAutenticado)){
                unlink(__DIR__.'/../assets/users/'.$fotoClass->traerPorUsuario($idUsuarioAutenticado)->getNombre());
                unlink(__DIR__.'/../assets/users/mobile/Mobile'.$fotoClass->traerPorUsuario($idUsuarioAutenticado)->getNombre());
                $fotoClass->eliminarFoto($idUsuarioAutenticado);
                echo 'se elimino la imagen';
            }
            $fotoClass->agregarFoto([
                'nombre' => $imagen, 
                'fk_usuario' => $idUsuarioAutenticado
            ]);
        }
    } catch (Exception $error) {
        echo 'error: <br>'.$error;
        $_SESSION['mensajeError'] = 'Ocurrio un error al subir la imagen';
        header('Location: ../index.php?s=profile');
        exit;
    }
    $_SESSION['mensajeExito'] = 'Los datos fueron actualizados correctamente';
        header('Location: ../index.php?s=profile');
        exit;
} catch (Exception $error) {
    $_SESSION['mensajeError'] = 'Oh no, Ocurrio un error inesperado en la edicion de datos del usuario';
    header('Location: ../index.php?s=profile');
    exit;
}