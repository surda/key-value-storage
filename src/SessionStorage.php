<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;
use Nette\Http\SessionSection;
use Nette\Http\Session;

class SessionStorage implements KeyValueStorage
{
    use TLoad;

    /** @var SessionSection */
    private $section;

    /**
     * @param string  $sectionName
     * @param Session $session
     */
    public function __construct(string $sectionName, Session $session)
    {
        $this->section = $session->getSection($sectionName);
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
        $value = $this->section[$key];

        return $value === NULL ? $default : $value;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function write($key, $value)
    {
        $this->section[$key] = $value;

        return $value;
    }

    /**
     * @param mixed $key
     * @return void
     */
    public function remove($key)
    {
        unset($this->section[$key]);
    }

    /**
     * @return void
     */
    public function clean()
    {
        $this->section->remove();
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function exists($key)
    {
        $value = $this->section[$key];

        return $value !== NULL;
    }
}