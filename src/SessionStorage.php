<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

use Surda\KeyValueStorage\Exception\NoSuchKeyException;
use Nette\Http\SessionSection;
use Nette\Http\Session;

class SessionStorage implements IKeyValueStorage
{
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
     * @param string $key
     * @return string
     */
    public function read(string $key): string
    {
        $value = $this->section[$key];

        if ($value === NULL) {
            throw NoSuchKeyException::forKey($key);
        }

        return $value;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function write(string $key, string $value): void
    {
        $this->section[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        unset($this->section[$key]);
    }

    public function clean(): void
    {
        $this->section->remove();
    }

    public function exists(string $key): bool
    {
        $value = $this->section[$key];

        return $value !== NULL;
    }
}