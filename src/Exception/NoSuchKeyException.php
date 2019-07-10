<?php declare(strict_types=1);

namespace Surda\KeyValueStorage\Exception;

class NoSuchKeyException extends \RuntimeException
{
    /**
     * Creates an exception for a key that was not found.
     *
     * @param string|int     $key   The key that was not found.
     * @param \Exception|null $cause The exception that caused this exception.
     *
     * @return static The created exception.
     */
    public static function forKey($key, \Exception $cause = NULL)
    {
        return new static(sprintf(
            'The key "%s" does not exist.',
            $key
        ), 0, $cause);
    }
}