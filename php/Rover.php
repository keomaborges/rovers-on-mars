<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Plateau.php';

class Rover
{
    protected int $orientation;
    protected Plateau $plateau;
    protected int $x;
    protected int $y;

    /**
     * Rover constructor.
     *
     * @param Plateau $plateau
     * @param int     $x
     * @param int     $y
     */
    public function __construct(Plateau $plateau, int $x, int $y)
    {
        $this->plateau = $plateau;
        $this->x = $x;
        $this->y = $y;

        //TODO: verify initial position is valid
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getCurrentCoordinates(string $separator = ','): string
    {
        return $this->x . $separator . $this->y;
    }

    /**
     * @return string
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
            case 4:
                return 'W';
        }
    }

    /**
     *
     */
    public function move(): void
    {
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
    }

    /**
     * @param string $orientation
     * @throws Exception
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
     *
     */
    public function turnLeft(): void
    {
        if (--$this->orientation < 1) {
            $this->orientation = 4;
        }
    }

    /**
     *
     */
    public function turnRight(): void
    {
        if (++$this->orientation > 4) {
            $this->orientation = 1;
        }
    }
}