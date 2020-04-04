<?php

namespace App;

use App\Exceptions\CrashException;
use App\Exceptions\InvalidPositionException;

/**
 * Defines a rover.
 *
 * Class Rover
 */
class Rover
{
    /**
     * Valid orientations
     */
    public const VALID_ORIENTATIONS = ['N', 'E', 'S', 'W'];

    /**
     * The ID in here there's no real meaning. It's an unique identifier to
     * identify different rovers on the same plateau.
     *
     * @var string
     */
    protected string $id;
    /**
     * In the code logic, the orientation is set as an integer value to make
     * it calculable.
     *
     * @var int
     */
    protected int $orientation;
    /**
     * A rover must be on a plateau.
     *
     * @var Plateau
     */
    protected Plateau $plateau;
    /**
     * @var int
     */
    protected int $x;
    /**
     * @var int
     */
    protected int $y;

    /**
     * Rover constructor.
     *
     * @param Plateau $plateau
     */
    public function __construct(Plateau $plateau)
    {
        $this->plateau = $plateau;
        $this->id = uniqid();
    }

    /**
     * Sets the coordinates of the rover.
     *
     * @param int $x the position on axis X
     * @param int $y the position on axis Y
     * @throws CrashException if the rover is launched upon another one
     *                        at the same position
     */
    public function setCoordinates(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;

        if ($at = $this->plateau->checkCrash($this)) {
            throw new CrashException($at);
        }
    }
    /**
     * Returns the current coordinates
     *
     * @param string $separator defaults to ','
     * @return string the current coordinates separated by the parameter
     */
    public function getCurrentCoordinates(string $separator = ','): string
    {
        return $this->x . $separator . $this->y;
    }

    /**
     * @return string the current ID
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string the "humanized" orientation
     */
    public function getOrientation(): string
    {
        switch ($this->orientation) {
            case 1:
                return 'N';
            case 2:
                return 'E';
            case 3:
                return 'S';
            default:
                return 'W';
        }
    }

    /**
     * Move this rover in the direction that it points to.
     *
     * @throws CrashException if the rover crashes to another
     * @throws InvalidPositionException if the rover tries to go to an invalid
     *                                  position on the plateau
     */
    public function move(): void
    {
        $previousX = $this->x;
        $previousY = $this->y;

        switch ($this->orientation) {
            case 1:
                $this->y++;
                break;
            case 2:
                $this->x++;
                break;
            case 3:
                $this->y--;
                break;
            case 4:
                $this->x--;
                break;
        }

        /**
         * If the position is invalid, the rover gets back to the previous
         * position and an exception is thrown.
         */
        if (!($at = $this->plateau->isValidPosition($this->x, $this->y))) {
            $invalidX = $this->x;
            $invalidY = $this->y;

            $this->x = $previousX;
            $this->y = $previousY;

            throw new InvalidPositionException($invalidX, $invalidY);
        }

        /**
         * If there's a crash, an exception is thrown.
         */
        if ($at = $this->plateau->checkCrash($this)) {
            throw new CrashException($at);
        }
    }

    /**
     * Sets the orientation based to the "humanized" format.
     *
     * @param string $orientation the desired orientation
     * @throws \Exception if it was provided an invalid orientation
     */
    public function setOrientation(string $orientation): void
    {
        switch (strtoupper($orientation)) {
            case 'N':
                $this->orientation = 1;
                break;
            case 'E':
                $this->orientation = 2;
                break;
            case 'S':
                $this->orientation = 3;
                break;
            case 'W':
                $this->orientation = 4;
                break;
            default:
                throw new \Exception('Invalid orientation provided. Valid values: N, E, S, W.');
        }
    }

    /**
     * Turns the rover left.
     * @return void
     */
    public function turnLeft(): void
    {
        if (--$this->orientation < 1) {
            $this->orientation = 4;
        }
    }

    /**
     * Turns the rover right.
     * @return void
     */
    public function turnRight(): void
    {
        if (++$this->orientation > 4) {
            $this->orientation = 1;
        }
    }
}
