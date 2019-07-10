<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;

class ArrayStorage implements IKeyValueStorage
{
    /** @var array */
    private $values;

    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * @param string $key
     * @return string
     * @throws NoSuchKeyException
     */
    public function read(string $key): string
    {
        if ($this->exists($key)) {
            $value = $this->values[$key];
        } else {
            $value = NULL;
        }

        if ($value === NULL) {
            throw NoSuchKeyException::forKey($key);
        }

        return (string)$value;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function write(string $key, string $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        if ($this->exists($key)) {
            unset($this->values[$key]);
        }
    }

    public function clean(): void
    {
        $this->values = [];
    }

    public function exists(string $key): bool
    {
        return array_key_exists($key, $this->values);
    }


}