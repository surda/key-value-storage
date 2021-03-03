<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;

class ArrayStorage implements KeyValueStorage
{
    use TLoad;

    /** @var array<mixed> */
    private $values;

    /**
     * @param array<mixed> $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * @param mixed $key
     * @return mixed
     * @throws NoSuchKeyException
     */
    public function readOrWarnOnUndefined($key)
    {
        $value = $this->read($key);

        if ($value === NULL) {
            throw NoSuchKeyException::forKey($key);
        }

        return $value;
    }

    /**
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function read($key, $default = NULL)
    {
        if ($this->exists($key)) {
            return $this->values[$key] === NULL ? $default : $this->values[$key];
        }

        return $default;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function write($key, $value)
    {
        $this->values[$key] = $value;

        return $value;
    }

    /**
     * @param mixed $key
     * @return void
     */
    public function remove($key)
    {
        if ($this->exists($key)) {
            unset($this->values[$key]);
        }
    }

    /**
     * @return void
     */
    public function clean()
    {
        $this->values = [];
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->values);
    }
}