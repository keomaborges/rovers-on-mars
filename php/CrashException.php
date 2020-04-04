<?php

/**
 * This exception is thrown when a rover crashes to another on the same plateau.
 *
 * Class CrashException
 */
class CrashException extends \Exception
{
    /**
     * @var string
     */
    protected string $coordinates;

    /**
     * CrashException constructor.
     *
     * @param string         $coordinates
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $coordinates,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->coordinates = $coordinates;
    }

    /**
     * The coordinates where the crash happened.
     *
     * @return string
     */
    public function getCoordinates(): string
    {
        return $this->coordinates;
    }
}