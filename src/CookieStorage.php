<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;
use Nette\Http\Request;
use Nette\Http\Response;

class CookieStorage implements IKeyValueStorage
{
    /** @var Request */
    private $httpRequest;

    /** @var Response */
    private $httpResponse;

    /** @var int */
    private $time;

    /**
     * @param int      $time expiration time in seconds
     * @param Request  $httpRequest
     * @param Response $httpResponse
     */
    public function __construct(int $time, Request $httpRequest, Response $httpResponse)
    {
        $this->time = $time;
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
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
        return $this->httpRequest->getCookie($key);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function write(string $key, string $value): void
    {
        $this->httpResponse->setCookie($key, $value, $this->time);
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        $this->httpResponse->deleteCookie($key);
    }

    public function clean(): void
    {
        foreach ($this->httpRequest->getCookies() as $key => $value) {
            $this->httpResponse->deleteCookie($key);
        }
    }

    public function exists(string $key): bool
    {
        return array_key_exists($key, $this->httpRequest->getCookies());
    }
}