<?php declare(strict_types=1);

namespace Surda\KeyValueStorage;

trait TLoad
{
    /**
     * @param mixed         $key
     * @param callable|null $fallback
     * @return mixed
     */
    public function load($key, $fallback = NULL)
    {
        $data = $this->read($key);

        if ($data === NULL && $fallback !== NULL) {
            $value = $fallback();

            return $this->write($key, $value);
        }

        return $data;
    }
}