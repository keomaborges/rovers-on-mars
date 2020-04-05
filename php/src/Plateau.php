<?php

namespace App;

/**
 * Class Plateau
 */
class Plateau
{
    /**
     * @var Rover[]
     */
    protected array $rovers;
    /**
     * @var int
     */
    protected int $x;
    /**
     * @var int
     */
    protected int $y;

    /**
     * Plateau constructor.
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        if ($x < 0) {
            throw new \InvalidArgumentException("X must be >= 0.");
        }

        if ($y < 0) {
            throw new \InvalidArgumentException("Y must be >= 0.");
        }

        $this->x = $x;
        $this->y = $y;
        $this->rovers = [];
    }

    /**
     * @param Rover $rover
     */
    public function addRover(Rover $rover)
    {
        foreach ($this->rovers as $currentRover) {
            if ($currentRover === $rover) {
                return;
            }
        }

        $this->rovers[] = $rover;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool|string
     */
    public function checkCrash(int $x, int $y)
    {
        foreach ($this->rovers as $i => $rover) {
            if ($rover->getCurrentCoordinates() === "$x,$y") {
                return $rover->getCurrentCoordinates();
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getRovers(): array
    {
        return $this->rovers;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getSize(string $separator = ','): string
    {
        return $this->x . $separator . $this->y;
    }

    /**
     * Checks if the given position is valid. A valid position is greater
     * or equal 0 and equal or less the size of the plateau.
     *
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isValidPosition(int $x, int $y): bool
    {
        return ($x >= 0) && ($y >= 0) && ($x <= $this->x) && ($y <= $this->y);
    }

    /**
     * @param Rover $rover
     */
    public function removeRover(Rover $rover)
    {
        foreach ($this->rovers as $i => $currentRover) {
            if ($currentRover->getId() === $rover->getId()) {
                unset($this->rovers[$i]);
                // re-indexes the array
                $this->rovers = array_values($this->rovers);
            }
        }
    }
}
