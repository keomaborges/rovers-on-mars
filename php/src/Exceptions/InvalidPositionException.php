<?php

namespace App\Exceptions;

/**
 * This exception is thrown when a rover tries to move to a invalid position
 * on the plateau.
 *
 * Class InvalidPositionException
 */
class InvalidPositionException extends \Exception
{
    /**
     * @var string
     */
    protected string $invalidX;
    /**
     * @var string
     */
    protected string $invalidY;

    /**
     * InvalidPositionException constructor.
     *
     * @param string         $invalidX
     * @param string         $invalidY
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $invalidX,
        string $invalidY,
        $message = "",
        $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->invalidX = $invalidX;
        $this->invalidY = $invalidY;
    }

    /**
     * @return string
     */
    public function getInvalidCoordinates()
    {
        return $this->invalidX . ',' . $this->invalidY;
    }
}
