<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Rover.php';

echo "\nInform the size of the plateau (two integers separated by space): ";

$positions = explode(' ', readline());
$plateau = new Plateau($positions[0], $positions[1]);

echo "\n";
echo sprintf('The upper-right coordinates of the plateau was set to %s', $plateau->getSize());
echo "\n";
echo 'Inform the coordinates of the rover and its orientation (e.g. 2 3 E): ';

$roverInfo = explode(' ', readline());
$rover = new Rover($plateau, $roverInfo[0], $roverInfo[1], $roverInfo[2]);
echo "\n";
echo sprintf('The rover is at %s and oriented to %s', $rover->getCurrentCoordinates(), $rover->getOrientation());

echo "\nInform movement instructions for the rover: ";
$movements = readline();
foreach(str_split($movements) as $movement) {
    switch (strtoupper($movement)) {
        case 'L':
            $rover->turnLeft();
            break;
        case 'R':
            $rover->turnRight();
            break;
        case 'M':
            $rover->move();
            break;
    }
}

echo "\n";
echo sprintf('Now the rover is at %s and pointing to %s.', $rover->getCurrentCoordinates(), $rover->getOrientation());