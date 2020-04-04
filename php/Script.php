<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Rover.php';

class Script
{
    protected ?Rover $currentRover;
    protected ?Plateau $plateau;

    public function __construct()
    {
        $this->plateau = null;
        $this->currentRover = null;

        echo "\n\n";
        echo 'Welcome to the rover controller program';
        echo "\n\n";
    }

    public function createPlateau()
    {
        echo "\n\n";

        echo "Inform the size of the plateau (two integers separated by space): ";

        $positions = explode(' ', readline());
        $plateau = new Plateau($positions[0], $positions[1]);

        echo "\n";
        echo sprintf('The upper-right coordinates of the plateau was set to %s', $plateau->getSize());

        $this->plateau = $plateau;

        $this->createRover();
    }

    public function createRover()
    {
        echo "\n\n";

        echo 'Inform the coordinates of the rover and its orientation (e.g. 2 3 E): ';

        $roverInfo = explode(' ', readline());
        $rover = new Rover($this->plateau);

        try {
            $rover->setCoordinates($roverInfo[0], $roverInfo[1]);
        } catch (\Exception $exception) {
            echo $exception->getMessage();

            $this->menu();
        }

        try {
            $rover->setOrientation($roverInfo[2]);
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }

        echo "\n\n";
        echo sprintf(
            'The rover is at %s and oriented to %s',
            $rover->getCurrentCoordinates(),
            $rover->getOrientation()
        );

        $this->plateau->addRover($rover);
        $this->currentRover = $rover;

        $this->operateRover();
    }

    public function menu()
    {
        echo "\n\n";


        echo 'What would like to do now?';
        echo "\n\n";
        echo '1 - Operate the current rover';
        echo "\n";
        echo '2 - Launch a new rover';
        echo "\n";
        echo '3 - List all the rovers for the current plateau'; //todo
        echo "\n";
        echo '4 - Operate in a new plateau';
        echo "\n";
        echo '5 - Exit';
        echo "\n\n";

        $option = readline();

        switch ($option) {
            case '1':
                $this->operateRover();
                break;
            case '2':
                $this->createRover();
                break;
            case '3':
                $this->showRovers();
                break;
            case '4':
                $this->createPlateau();
                break;
            default:
                echo "Bye!";
                exit;
        }
    }

    public function operateRover()
    {
        echo "\n\n";

        echo "Inform movement instructions for the rover: ";
        $movements = readline();
        foreach(str_split($movements) as $movement) {
            switch (strtoupper($movement)) {
                case 'L':
                    $this->currentRover->turnLeft();
                    break;
                case 'R':
                    $this->currentRover->turnRight();
                    break;
                case 'M':
                    try {
                        $this->currentRover->move();
                    } catch (\Exception $exception) {
                        echo $exception->getMessage();
                    }
                    break;
            }
        }

        echo "\n\n";
        echo sprintf(
            'Now the rover is at %s and pointing to %s.',
            $this->currentRover->getCurrentCoordinates(),
            $this->currentRover->getOrientation()
        );

        $this->menu();
    }

    public function showRovers()
    {
        echo "\n\n";

        if (sizeof($this->plateau->getRovers()) === 0) {
            echo 'The current plateau has no rovers.';
        } else {
            foreach ($this->plateau->getRovers() as $i => $rover) {
                echo sprintf(
                    "Rover $i is at %s and pointing to %s.",
                    $rover->getCurrentCoordinates(),
                    $rover->getOrientation()
                );
                echo "\n";
            }
        }

        $this->menu();
    }
}

$script = new Script();
$script->createPlateau();