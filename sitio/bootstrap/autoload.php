<?php
//Autoload de Compouser:
require_once __DIR__ . '/../vendor/autoload.php';
//Autoload de ChatLand
spl_autoload_register(function($nombreDeLaClase){
    $nombreDeLaClase = substr($nombreDeLaClase, 11);// Elimina mi nombre de usuario de Github...
    $nombreDeLaClase = str_replace('\\', '/', $nombreDeLaClase); // Reemplazar barras invertidas por barras diagonales

    $rutaDeLaClase = __DIR__ . '/../clases/'. $nombreDeLaClase.'.php';
    $rutaDeLaClaseModelos = __DIR__ . '/../clases/modelos/'. $nombreDeLaClase.'.php';
    $rutaDeLaClaseAutenticacion = __DIR__ . '/../clases/auth/'. $nombreDeLaClase.'.php';
    $rutaDeLaClaseDB = __DIR__ . '/../clases/db/'. $nombreDeLaClase.'.php';
    // echo "Buscando la clase: ".$nombreDeLaClase."<br>";

    if (file_exists($rutaDeLaClase)) {//carpeta raiz de las clases
        require_once $rutaDeLaClase;
    } elseif (file_exists($rutaDeLaClaseModelos)) {//subcarpeta modelos
        require_once $rutaDeLaClaseModelos;
    }elseif (file_exists($rutaDeLaClaseAutenticacion)) {//subcarpeta autenticacion
        require_once $rutaDeLaClaseAutenticacion;
    }elseif (file_exists($rutaDeLaClaseDB)) {//subcarpeta base de datos
        require_once $rutaDeLaClaseDB;
    } else {
        //echo "No se encontró el archivo de clase<br>";
    }
});