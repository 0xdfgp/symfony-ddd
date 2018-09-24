<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

class Content
{
    /**
     * @var string
     */
    private $value;

    /**
     * Content constructor.
     *
     * @param string $value
     * @throws InvalidContent
     */
    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws InvalidContent
     */
    private function guard(string $value): void
    {
        if (\strlen($value) === 0) {
            throw new InvalidContent($value);
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
     * @param Content $content
     * @return bool
     */
    public function equals(Content $content): bool
    {
        return $this->value === $content->value();
    }
}
