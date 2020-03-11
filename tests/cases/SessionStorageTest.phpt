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

        Assert::null($storage->readOrNull('name'));

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

(new SessionStorageTest())->run();