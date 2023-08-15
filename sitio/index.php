<?php
    session_start();
    require_once __DIR__.'/bootstrap/autoload.php';

    $rutas = [
        'error' => [
         'title' => 'Página no encontrada',
        ],
         'chat' => [
          'title' => 'Chat',
          'requiereAutenticacion' => true
         ],
         'chats' => [
          'title' => 'Tus conversaciones',
          'requiereAutenticacion' => true
         ],
         'profile' => [
          'title' => 'Tu perfil',
          'requiereAutenticacion' => true
         ],
         'editar-usuario' => [
          'title' => 'Tu perfil',
          'requiereAutenticacion' => true
         ],
         'login'=>[
          'title' => 'Log in'
         ],
         'registro'=>[
          'title'=>'Registro'
         ],
        ];

    $vista = $_GET['s'] ?? 'login';

  if(!isset($rutas[$vista])) {
    // Esta vista no "existe", así que mostramos una pantalla de error.
    $vista = 'error';
  }

  $rutaOpciones = $rutas[$vista];

  $autenticacion = new Auth();
  $requiereAutenticacion = $rutaOpciones['requiereAutenticacion'] ?? false;
  if($requiereAutenticacion && !$autenticacion->estaAutenticado()){
    $_SESSION['mensajeError'] = 'Se requiere haber iniciado sesion para ver este contenido.';
    header('Location: index.php?s=login');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $rutaOpciones['title'];?> :: ChatLand</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<?php
        if(isset($_SESSION['mensajeExito'])):
        ?>
        <div class="msg-exito"><?= $_SESSION['mensajeExito']; ?></div>
        <?php
        unset($_SESSION['mensajeExito']);
        endif;
        ?>
        <?php
        if(isset($_SESSION['mensajeError'])):
        ?>
        <div class="msg-error"><?= $_SESSION['mensajeError']; ?></div>
        <?php
        unset($_SESSION['mensajeError']);
        endif;
        ?>
    <main>
        <?php
        require_once __DIR__ . '/secciones/' . $vista . '.php';
        ?>
    </main>

    <script src="js/codigo.js"></script>
</body>
</html>