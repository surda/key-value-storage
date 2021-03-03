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

        Assert::null($storage->read('name'));
        Assert::same('bar', $storage->read('name', 'bar'));

        Assert::exception(function () use ($storage) {
            $storage->readOrWarnOnUndefined('name');
        }, NoSuchKeyException::class, 'The key "name" does not exist.');

        $storage->write('name', 'John');
        Assert::same('John', $storage->read('name'));

        $storage->remove('foo');
        Assert::false($storage->exists('foo'));

        $storage->clean();
        Assert::false($storage->exists('name'));

        Assert::false($storage->exists('baz'));
        Assert::same('abc', $storage->load('baz', function () {
            return 'abc';
        }));
        Assert::same('abc', $storage->read('baz'));
    }
}

(new ArrayStorageTest())->run();