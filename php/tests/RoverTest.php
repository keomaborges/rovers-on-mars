<?php

namespace App\Tests;

use App\Exceptions\CrashException;
use App\Exceptions\InvalidPositionException;
use App\Rover;

class RoverTest extends CommonTestCase
{
    public function testCreateRover()
    {
        $rover = $this->createRover();
        $this->assertInstanceOf(Rover::class, $rover);
    }

    public function testLaunchRoversSuccessfully()
    {
        $plateau = $this->createPlateau(10, 10);

        // Launch the first rover upon the plateau
        $rover1 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover1);
        $rover1->setCoordinates(5, 5);

        // Launch the second one in a valid position
        $rover2 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover2);
        $rover2->setCoordinates(2, 3);
    }

    public function testLaunchRoverAtInvalidPosition()
    {
        $plateau = $this->createPlateau(5, 5);

        // Launch the third in a invalid position
        $rover = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover);

        $this->expectException(InvalidPositionException::class);
        $rover->setCoordinates(13, 6);
    }

    public function testLaunchRoverUponAnotherOne()
    {
        $plateau = $this->createPlateau(10, 10);

        // Launch the first rover upon the plateau
        $rover1 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover1);
        $rover1->setCoordinates(5, 5);

        // Launch the second one upon the first
        $rover = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover);
        $this->expectException(CrashException::class);
        $rover->setCoordinates(5, 5);
    }

    public function testMoveRoverSuccessfully()
    {
        $plateau = $this->createPlateau(10, 10);

        // Launch the first rover upon the plateau
        $rover1 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover1);
        $rover1->setCoordinates(1, 2);
        $rover1->setOrientation('N');
        $this->assertEquals($rover1->getOrientation(), 'N');

        $rover1->turnLeft();
        $this->assertEquals('W', $rover1->getOrientation());

        $rover1->move();
        $this->assertEquals('0,2', $rover1->getCurrentCoordinates());

        $rover1->turnLeft();
        $this->assertEquals('S', $rover1->getOrientation());

        $rover1->move();
        $this->assertEquals('0,1', $rover1->getCurrentCoordinates());

        $rover1->turnLeft();
        $this->assertEquals('E', $rover1->getOrientation());

        $rover1->move();
        $this->assertEquals('1,1', $rover1->getCurrentCoordinates());

        $rover1->turnLeft();
        $this->assertEquals('N', $rover1->getOrientation());

        $rover1->move();
        $this->assertEquals('1,2', $rover1->getCurrentCoordinates());

        $rover1->move();
        $this->assertEquals('1,3', $rover1->getCurrentCoordinates());
    }

    public function testMoveRoverToInvalidPosition()
    {
        $plateau = $this->createPlateau(5, 5);

        // Launch the first rover upon the plateau
        $rover1 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover1);
        $rover1->setCoordinates(1, 2);
        $rover1->setOrientation('N');
        $this->assertEquals($rover1->getOrientation(), 'N');

        $rover1->turnLeft();
        $this->assertEquals('W', $rover1->getOrientation());

        $rover1->move();
        $this->assertEquals('0,2', $rover1->getCurrentCoordinates());

        $rover1->turnLeft();
        $this->assertEquals('S', $rover1->getOrientation());

        $rover1->move();
        $this->assertEquals('0,1', $rover1->getCurrentCoordinates());

        $rover1->move();
        $this->assertEquals('0,0', $rover1->getCurrentCoordinates());

        // at this point, the rover would try to move to 0, -1
        try {
            $rover1->move();
        } catch (InvalidPositionException $exception) {
            $this->assertEquals($exception->getInvalidCoordinates(), '0,-1');
        }
    }

    public function testMoveRoverCrashes()
    {
        $plateau = $this->createPlateau(5, 5);

        // Launch the first rover upon the plateau
        $rover1 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover1);
        $rover1->setCoordinates(1, 2);
        $rover1->setOrientation('N');
        $this->assertEquals($rover1->getOrientation(), 'N');
        $this->assertEquals($rover1->getCurrentCoordinates(), '1,2');

        // Launch the second one
        $rover2 = $this->createRover($plateau);
        $this->assertInstanceOf(Rover::class, $rover2);
        $rover2->setCoordinates(0,0);
        $rover2->setOrientation('N');
        $this->assertEquals($rover2->getOrientation(), 'N');

        $rover2->move();
        $this->assertEquals($rover2->getCurrentCoordinates(), '0,1');

        $rover2->move();
        $this->assertEquals($rover2->getCurrentCoordinates(), '0,2');

        $rover2->turnRight();
        $this->assertEquals($rover2->getOrientation(), 'E');

        // at this point, the rover would crash to another
        try {
            $rover2->move();
        } catch (CrashException $exception) {
            $this->assertEquals($exception->getCoordinates(), $rover1->getCurrentCoordinates());
        }
    }

    public function testSetOrientation()
    {
        $rover = $this->createRover();

        $rover->setOrientation('E');
        $this->assertEquals($rover->getOrientation(), 'E');

        $rover->setOrientation('S');
        $this->assertEquals($rover->getOrientation(), 'S');

        $rover->setOrientation('W');
        $this->assertEquals($rover->getOrientation(), 'W');

        $rover->turnRight();
        $this->assertEquals($rover->getOrientation(), 'N');

        $this->expectException(\Exception::class);
        $rover->setOrientation('X');
    }
}