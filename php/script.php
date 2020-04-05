<?php

spl_autoload_register(
    function () {
        $src = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR ;

        require_once $src . 'Script.php';
        require_once $src . 'Plateau.php';
        require_once $src . 'Rover.php';
        require_once $src . 'Exceptions' . DIRECTORY_SEPARATOR . 'CrashException.php';
        require_once $src . 'Exceptions' . DIRECTORY_SEPARATOR . 'InvalidPositionException.php';
    }
);

$script = new \App\Script();
$script->createPlateau();