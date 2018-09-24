<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

class Name
{
    /**
     * @var string
     */
    private $value;

    /**
     * Name constructor.
     *
     * @param string $value
     * @throws InvalidName
     */
    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws InvalidName
     */
    private function guard(string $value): void
    {
        if (\strlen($value) === 0) {
            throw new InvalidName($value);
        }
    }

    /**
     * Value as plain string.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param Name $name
     * @return bool
     */
    public function equals(Name $name): bool
    {
        return $this->value === $name->value();
    }
}
