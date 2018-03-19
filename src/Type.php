<?php declare(strict_types=1);

namespace Ellipse\Exceptions;

class Type
{
    /**
     * The type a detailled string representation is needed.
     *
     * @var string
     */
    private $type;

    /**
     * Set up a type with the given type name.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Return a detailled string representation of the type.
     *
     * @return string
     */
    public function __toString()
    {
        if (interface_exists($this->type) || class_exists($this->type)) {

            return sprintf('object implementing %s', $this->type);

        }

        return $this->type;
    }
}
