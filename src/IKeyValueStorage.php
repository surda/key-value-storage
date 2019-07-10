<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;

interface IKeyValueStorage
{
    /**
     * @param  string $key
     * @return string
     * @throws NoSuchKeyException
     */
    public function read(string $key): string;

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function write(string $key, string $value): void;

    /**
     * @param  string $key
     * @return void
     */
    public function remove(string $key): void;

    /**
     * @return void
     */
    public function clean(): void;

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key):bool;

}