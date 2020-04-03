<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Rover.php';

function setPlateau()
{
    echo "\nInform the size of the plateau (two integers separated by space): ";

    $positions = explode(' ', readline());
    $plateau = new Plateau($positions[0], $positions[1]);

    echo "\n";
    echo sprintf('The upper-right coordinates of the plateau was set to %s', $plateau->getSize());

    return $plateau;
}

function createRover(Plateau $plateau)
{
    echo 'Inform the coordinates of the rover and its orientation (e.g. 2 3 E): ';

    $roverInfo = explode(' ', readline());
    $rover = new Rover($plateau, $roverInfo[0], $roverInfo[1]);

    try {
        $rover->setOrientation($roverInfo[2]);
    } catch (\Throwable $exception) {
        echo $exception->getMessage();
    }

    echo "\n";
    echo sprintf('The rover is at %s and oriented to %s', $rover->getCurrentCoordinates(), $rover->getOrientation());

    return $rover;
}

function operateRover(Rover $rover)
{
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
}

$plateau = setPlateau();
echo "\n\n";
$rover = createRover($plateau);
echo "\n\n";
operateRover($rover);
echo "\n\n";
$rovers[] = $rover;

echo 'What would like to do now?';
echo "\n\n";
echo '1 - Operate the current rover';
echo "\n";
echo '2 - Launch a new rover';
echo "\n";
echo '3 - Operate in a new plateau';
echo "\n";
echo '4 - Exit';
echo "\n\n";