<?php
session_start();
require_once __DIR__ . '/../clases/db/DB.php';
require_once __DIR__ . '/../clases/modelos/Usuarios.php';

$email = $_POST['email'];
$username = trim($_POST['username']);
$password = $_POST['password'];

$errores = [];
if(empty($email)){
    $errores['email'] = 'Tu usuario debe poseer un email';
}
foreach ((new Usuarios) as $usuarioExistente) 
{
    if ($email == $usuarioExistente->getEmail()) 
    {
        $errores['email'] = 'Este email ya esta registrado';
    }
}
if(empty($email)){
    $errores['email'] = 'Tu usuario debe poseer un email';
}
foreach ((new Usuarios) as $usernameExistente) 
{
    if ($username == $usernameExistente->getUsername()) 
    {
        $errores['username'] = 'Alguien ya esta utilizando este username';
    }
}
if (empty($password)) {
    $errores['password'] = 'Tu usuario debe poseer una contraseña';
}
if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['oldData'] = $_POST;
    header('Location: ../index.php?s=crear-cuenta');
    var_dump($errores);
    exit;
    }

    try {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaRecuperada = new DateTime();
        $fechaFormateada = $fechaRecuperada->format('Y-m-d H:i:s.u');

        $nombreDeUsuario = '$'.$username;
        (new Usuarios)->crear([
            'email'=>$email,
            'username'=>$nombreDeUsuario,
            'password'=>password_hash($password, PASSWORD_DEFAULT),
            'ultima_conexion'=>$fechaFormateada
        ]);
        $_SESSION['mensajeExito'] = 'Has creado un nuevo usuario';
        header('Location: ../index.php?s=login');
        exit;
    } catch (\Throwable $th) {
        $_SESSION['mensajeError'] = 'Oh no, Ocurrio un error inesperado en el registro del usuario';
        header('Location: ../index.php?s=crear-cuenta');
        exit;
    }