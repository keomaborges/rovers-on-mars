<?php

namespace App\Tests;

use App\Plateau;
use App\Rover;

class PlateauTest extends CommonTestCase
{
    public function testCreatePlateau()
    {
        $plateau = $this->createPlateau(10, 10);
        $this->assertInstanceOf(Plateau::class, $plateau);
        $this->assertEmpty($plateau->getRovers());
        $this->assertEquals('10,10', $plateau->getSize());
    }

    public function testCreateInvalidPlateau()
    {
        try {
            new Plateau(-1, 8);
        } catch (\InvalidArgumentException $exception) {
            $this->assertEquals('X must be >= 0.', $exception->getMessage());
        }

        try {
            new Plateau(0, -5);
        } catch (\InvalidArgumentException $exception) {
            $this->assertEquals('Y must be >= 0.', $exception->getMessage());
        }
    }

    public function testAddAndRemoveRover()
    {
        $plateau = $this->createPlateau(5, 5);
        $firstRover = $this->createRover($plateau);
        $secondRover = $this->createRover($plateau);

        $plateau->addRover($firstRover);
        $this->assertEquals(1, sizeof($plateau->getRovers()));

        $plateau->addRover($secondRover);
        $this->assertEquals(2, sizeof($plateau->getRovers()));

        $plateau->addRover($secondRover);
        $this->assertEquals(2, sizeof($plateau->getRovers()));

        $plateau->removeRover($firstRover);
        $this->assertEquals(1, sizeof($plateau->getRovers()));
        $this->assertInstanceOf(Rover::class, $plateau->getRovers()[0]);
    }
}