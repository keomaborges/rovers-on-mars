<?php

class Plateau
{
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
}