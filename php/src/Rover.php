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
     * Sets the coordinates of the rover and adds it to the plateau.
     *
     * @param int $x the position on axis X
     * @param int $y the position on axis Y
     * @throws CrashException if the rover is launched upon another one
     *                        at the same position
     * @throws InvalidPositionException if the rover is launched to an invalid
     *                                  position on the plateau
     */
    public function setCoordinates(int $x, int $y)
    {
        if (!($at = $this->plateau->isValidPosition($x, $x))) {
            throw new InvalidPositionException($x, $y);
        }

        if ($at = $this->plateau->checkCrash($x, $y)) {
            throw new CrashException($at);
        }

        $this->x = $x;
        $this->y = $y;
        $this->plateau->addRover($this);
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
     * Returns the ID of the rover.
     *
     * @return string the current ID
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Returns the orientation of the rover.
     *
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
        $x = $this->x;
        $y = $this->y;

        switch ($this->orientation) {
            case 1:
                $y++;
                break;
            case 2:
                $x++;
                break;
            case 3:
                $y--;
                break;
            case 4:
                $x--;
                break;
        }

        /**
         * If the position is invalid, an exception is thrown.
         */
        if (!($at = $this->plateau->isValidPosition($x, $y))) {
            throw new InvalidPositionException($x, $y);
        }

        /**
         * If there's a crash, an exception is thrown.
         */
        if ($at = $this->plateau->checkCrash($x, $y)) {
            throw new CrashException($at);
        }

        $this->x = $x;
        $this->y = $y;
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
