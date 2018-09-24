<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

class Password
{
    /**
     * @var string
     */
    private $value;

    /**
     * Password constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
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
}
