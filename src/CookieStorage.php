<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;
use Nette\Http\Request;
use Nette\Http\Response;

class CookieStorage implements KeyValueStorage
{
    use TLoad;

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
        $value = $this->httpRequest->getCookie($key);

        return $value === NULL ? $default : $value;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function write($key, $value)
    {
        $this->httpResponse->setCookie($key, $value, $this->time);

        return $value;
    }

    /**
     * @param mixed $key
     * @return void
     */
    public function remove($key)
    {
        $this->httpResponse->deleteCookie($key);
    }

    /**
     * @return void
     */
    public function clean()
    {
        foreach ($this->httpRequest->getCookies() as $key => $value) {
            $this->httpResponse->deleteCookie($key);
        }
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->httpRequest->getCookies());
    }
}