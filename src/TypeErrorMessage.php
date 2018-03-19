<?php declare(strict_types=1);

namespace Ellipse\Exceptions;

class TypeErrorMessage
{
    /**
     * The message template.
     *
     * @var string
     */
    const TEMPLATE = 'Trying to use a value of type %s as %s - %s expected';

    /**
     * The role of the value should have.
     *
     * @var string
     */
    private $role;

    /**
     * The value with an invalid type.
     *
     * @var \Ellipse\Exceptions\Value
     */
    private $value;

    /**
     * The expected type.
     *
     * @var \Ellipse\Exceptions\Type
     */
    private $type;

    /**
     * Set up a type error message with the given role, value and type.
     *
     * @param string    $role
     * @param mixed     $value
     * @param string    $type
     */
    public function __construct(string $role, $value, string $type)
    {
        $this->role = $role;
        $this->value = new Value($value);
        $this->type = new Type($type);
    }

    /**
     * Return a string representation of the message.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(self::TEMPLATE, $this->value->type(), $this->role, $this->type);
    }
}
