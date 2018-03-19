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
        if (is_string($this->value)) {

            return $this->string($this->value);

        }

        if (is_array($this->value)) {

            return $this->array($this->value);

        }

        if (is_object($this->value)) {

            return $this->object($this->value);

        }

        return gettype($this->value);
    }

    private function string(string $string): string
    {
        return sprintf('string (\'%s\')', $this->truncate($string, 40));
    }

    private function truncate($string, int $length): string
    {
        return strlen($string) > $length
            ? substr($string, 0, $length - 3) . '...'
            : $string;
    }

    private function array(array $array): string
    {
        $keys = array_map([$this, 'arrayKey'], array_slice(array_keys($array), 0, 3));
        $values = array_map([$this, 'arrayValue'], array_slice(array_values($array), 0, 3));

        $strings = array_map(function ($key, $value) {

            return sprintf('%s => %s', $key, $value);

        }, $keys, $values);

        if (count($array) > 3) {

            array_pop($strings);

            $strings[] = '...';

        }

        return 'array ([' . implode(', ', $strings) . '])';
    }

    private function arrayKey($key): string
    {
        if (is_string($key)) {

            return sprintf('\'%s\'', $key);

        }

        return (string) $key;
    }

    private function arrayValue($value): string
    {
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                return $value ? 'true' : 'false';
                break;
            case 'integer':
                return (string) $value;
                break;
            case 'double':
                return (string) $value;
                break;
            case 'string':
                return sprintf('\'%s\'', $this->truncate($value, 10));
                break;
            case 'array':
                return '[...]';
                break;
            case 'object':
                return $this->object($value);
                break;
            case 'resource':
                return 'resource';
            case 'NULL':
                return 'NULL';
                break;
            default:
                return $type;
                break;
        }
    }

    private function object($object): string
    {
        $reflection = new ReflectionClass($object);

        if ($reflection->isAnonymous()) {

            return 'object';

        }

        return get_class($object);
    }
}
