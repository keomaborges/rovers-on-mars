<?php

class Plateau
{
    /**
     * @var Rover[]
     */
    protected array $rovers;
    protected int $x;
    protected int $y;

    /**
     * Plateau constructor.
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->rovers = [];
    }

    public function addRover(Rover $rover)
    {
        $this->rovers[] = $rover;
    }

    public function checkCrash(Rover $movingRover)
    {
        foreach ($this->rovers as $i => $rover) {
            if (
                $rover->getId() !== $movingRover->getId()
                && $movingRover->getCurrentCoordinates() === $rover->getCurrentCoordinates()
            ) {
                $coordinates = $rover->getCurrentCoordinates();
                $this->removeRover($movingRover);
                unset($this->rovers[$i]);
                return $coordinates;
            }
        }

        return false;
    }

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
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isValidPosition(int $x, int $y): bool
    {
        return ($this->x <= $x) && ($this->y <= $y);
    }

    public function removeRover(Rover $rover)
    {
        foreach ($this->rovers as $i => $currentRover) {
            if ($currentRover->getId() === $rover->getId()) {
                unset($this->rovers[$i]);
            }
        }
    }
}