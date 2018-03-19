<?php declare(strict_types=1);

namespace Ellipse\Exceptions;

use ReflectionClass;

class Value
{
    /**
     * The value a detailled type representation is needed.
     *
     * @var mixed
     */
    private $value;

    /**
     * Set up a value with the given value.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Return a detailled string representation of the value.
     *
     * @return string
     */
    public function type(): string
    {
        if (! is_object($this->value) && is_callable($this->value)) {

            return $this->callable($this->value);

        }

        if (is_object($this->value)) {

            return $this->object($this->value);

        }

        if (is_string($this->value)) {

            return $this->string($this->value);

        }

        return gettype($this->value);
    }

    private function string(string $string): string
    {
        $truncated = strlen($string) > 40
            ? substr($string, 0, 37) . '...'
            : $string;

        return sprintf('string (%s)', $truncated);
    }

    private function callable(callable $callable): string
    {
        if (is_array($callable)) {

            if (is_string($callable[0])) {

                return sprintf('callable ([%s, %s])', $callable[0], $callable[1]);

            }

            if (is_object($callable[0])) {

                return sprintf('callable ([%s, %s])', $this->object($callable[0]), $callable[1]);

            }

        }

        return sprintf('callable (%s)', $callable);
    }

    private function object($object): string
    {
        $reflection = new ReflectionClass($object);

        if ($reflection->isAnonymous()) {

            return 'object (anonymous class)';

        }

        return get_class($object);
    }
}
