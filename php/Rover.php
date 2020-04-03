<?php

namespace App\PHP;

use App\PHP\Plateau;

class Rover
{
    protected int $x;
    protected int $y;
    protected Plateau $plateau;
    protected int $orientation;

    /**
     * Undocumented function
     *
     * @param Plateau $plateau
     * @param integer $x
     * @param integer $y
     */
    public function __construct(Plateau $plateau, int $x, int $y, string $orientation)
    {
        $this->plateau = $plateau;
        $this->x = $x;
        $this->y = $y;
        $this->orientation = $this->setOrientation($orientation);
    }

    public function turnLeft()
    {
        if (--$this->orientation < 1) {
            $this->orientation = 4;
        }
    }

    public function turnRight(): void
    {
        if (++$this->orientation > 4) {
            $this->orientation = 1;
        }
    }

    public function move()
    {
        # code...
    }

    /**
     * Undocumented function
     *
     * @param string $orientation
     * @return integer
     * @throws Exception 
     */
    public function setOrientation(string $orientation): int
    {
        switch (strtoupper($orientation)) {
            case 'N':
                return 1;
            case 'E':
                return 2;
            case 'S':
                return 3;
            case 'W':
                return 4;
            default:
                throw new \Exception('Invalid orientation provided. Valid values: N, E, S, W.');
        }
    }

    public function getOrientation()
    {
        switch ($this->orientation) {
            case 1:
                return 'N';
            case 2:
                return 'E';
            case 3:
                return 'S';
            case 4:
                return 'W';
        }
    }
}