<?php

namespace App\Tests;

use App\Rover;
use PHPUnit\Framework\TestCase;
use App\Plateau;
use App\Script;

class CommonTestCase extends TestCase
{
    protected function createPlateau(int $x, int $y)
    {
        $plateau = new Plateau($x, $y);

        return $plateau;
    }

    protected function createRover(?Plateau $plateau = null)
    {
        if (is_null($plateau)) {
            $plateau = $this->createPlateau(10, 10);
        }

        return new Rover($plateau);
    }
}