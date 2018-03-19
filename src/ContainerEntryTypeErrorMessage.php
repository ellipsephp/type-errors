<?php declare(strict_types=1);

namespace Ellipse\Exceptions;

class ContainerEntryTypeErrorMessage
{
    /**
     * The message template.
     *
     * @var string
     */
    const TEMPLATE = 'The \'%s\' entry of the container has type %s - %s expected';

    /**
     * The container entry id.
     *
     * @var string
     */
    private $id;

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
     * Set up a type error message with the given container id, value and type.
     *
     * @param string    $id
     * @param mixed     $value
     * @param string    $type
     */
    public function __construct(string $id, $value, string $type)
    {
        $this->id = $id;
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
        return sprintf(self::TEMPLATE, $this->id, $this->value->type(), $this->type);
    }
}
