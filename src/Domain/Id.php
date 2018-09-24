<?php
declare(strict_types=1);

namespace App\Domain;

abstract class Id
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Id constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param Id $id
     * @return true
     */
    public function equals(Id $id): bool
    {
        return $this->value === $id->value();
    }
}
