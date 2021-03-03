<?php declare(strict_types=1);

namespace Tests\Surda\ItemsPerPage;

use Nette\Http\Request;
use Nette\Http\Response;
use Nette\Http\Session;
use Nette\Http\UrlScript;
use Surda\KeyValueStorage\Exception\NoSuchKeyException;
use Surda\KeyValueStorage\SessionStorage;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class SessionStorageTest extends TestCase
{
    public function testStorage()
    {
        $session = new Session(new Request(new UrlScript), new Response);

        $namespace = $session->getSection('one');
        $namespace->foo = 'bar';

        $storage = new SessionStorage('one', $session);

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

        $storage->write('foo', 10);
        Assert::same(10, $storage->read('foo'));

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

(new SessionStorageTest())->run();