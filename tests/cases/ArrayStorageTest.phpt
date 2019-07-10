<?php declare(strict_types=1);

namespace Tests\Surda\ItemsPerPage;

use Surda\KeyValueStorage\ArrayStorage;
use Surda\KeyValueStorage\Exception\NoSuchKeyException;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ArrayStorageTest extends TestCase
{
    public function testStorage()
    {
        $storage = new ArrayStorage(['foo' => 'bar']);

        Assert::true($storage->exists('foo'));
        Assert::same('bar', $storage->read('foo'));

        Assert::false($storage->exists('name'));

        Assert::exception(function () use ($storage) {
            $storage->read('name');
        }, NoSuchKeyException::class, 'The key "name" does not exist.');

        $storage->write('name', 'John');
        Assert::same('John', $storage->read('name'));

        $storage->remove('foo');
        Assert::false($storage->exists('foo'));

        $storage->clean();
        Assert::false($storage->exists('name'));
    }
}

(new ArrayStorageTest())->run();