<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;

interface KeyValueStorage
{
    /**
     * @param mixed $key
     * @param callable|null $fallback
     * @return mixed
     */
    public function load($key, $fallback = NULL);

    /**
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function read($key, $default = NULL);

    /**
     * @param mixed $key
     * @return mixed
     * @throws NoSuchKeyException
     */
    public function readOrWarnOnUndefined($key);

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function write($key, $value);

    /**
     * @param mixed $key
     * @return void
     */
    public function remove($key);

    /**
     * @return void
     */
    public function clean();

    /**
     * @param mixed $key
     * @return bool
     */
    public function exists($key);
}