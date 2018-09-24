<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

class PlainPassword
{
    /**
     * @var string
     */
    private $value;

    /**
     * Password constructor.
     *
     * @param string $value
     * @throws InvalidPassword
     */
    public function __construct(string $value)
    {
        $value = $this->scapeCharacters($value);
        $this->guardLength($value);
        $this->guardNotConsecutiveCharacters($value);

        $this->value = $value;
    }

    private function scapeCharacters(string $value): string
    {
        return preg_quote($value, '/');
    }

    /**
     * @param string $value
     * @throws InvalidPassword
     */
    private function guardNotConsecutiveCharacters(string $value): void
    {
        $consecutiveCharacters = [
            'º1234567890',
            'qwertyuiop',
            'asdfghjklñ',
            '<zxcvbnm,.-'
        ];

        $matches = preg_grep("/{$value}/", $consecutiveCharacters);
        if (!empty($matches)) {
            throw new InvalidPassword($value);
        }
    }

    /**
     * @param string $value
     * @throws InvalidPassword
     */
    private function guardLength(string $value): void
    {
        if (\strlen($value) < 6) {
            throw new InvalidPassword($value);
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
}
