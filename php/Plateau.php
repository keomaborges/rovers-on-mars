<?php

namespace App\PHP;

class Plateau
{
    protected int $x;
    protected int $y;
    
    /**
     * Undocumented function
     *
     * @param integer $x
     * @param integer $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Undocumented function
     *
     * @param integer $x
     * @param integer $y
     * @return boolean
     */
    public function isValidPosition(int $x, int $y): bool
    {
        return ($this->x <= $x) && ($this->y <= $y);
    }
}