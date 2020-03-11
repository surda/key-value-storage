<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;

class ArrayStorage implements IKeyValueStorage
{
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
     * @param string $key
     * @return string
     * @throws NoSuchKeyException
     */
    public function read(string $key): string
    {
        $value = $this->readOrNull($key);

        if ($value === NULL) {
            throw NoSuchKeyException::forKey($key);
        }

        return $value;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function readOrNull(string $key): ?string
    {
        if ($this->exists($key)) {
            return $this->values[$key];
        }

        return NULL;
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