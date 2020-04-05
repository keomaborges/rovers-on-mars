<?php

if (!file_exists($file = __DIR__ . '/../vendor/autoload.php')
    && !file_exists($file = __DIR__ . '/../../../../vendor/autoload.php')
) {
    throw new RuntimeException('Install dependencies to run this script.');
}

$loader = require_once $file;

spl_autoload_register(
    function () {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        $src = $dir . 'src' . DIRECTORY_SEPARATOR ;
        $tests = $dir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR;

        require_once $src . 'Script.php';
        require_once $src . 'Plateau.php';
        require_once $src . 'Rover.php';
        require_once $src . 'Exceptions' . DIRECTORY_SEPARATOR . 'CrashException.php';
        require_once $src . 'Exceptions' . DIRECTORY_SEPARATOR . 'InvalidPositionException.php';
        require_once $tests . 'CommonTestCase.php';
        require_once $tests . 'PlateauTest.php';
    }
);