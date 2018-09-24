<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\SafeBox;

use App\Domain\Safebox\InvalidPassword;
use App\Domain\Safebox\PlainPassword;
use PHPUnit\Framework\TestCase;

class PlainPasswordTest extends TestCase
{
    public function invalidPasswordProvider(): array
    {
        return [
            // shorter than 6 characters
            [''],
            ['1xFgZ'],
            // consecutive characters
            ['º12345'],
            ['67890'],
            ['1234567890'],
            ['qwerty'],
            ['tyuiop'],
            ['asdfgh'],
            ['zxcvbn']
        ];
    }

    /**
     * @dataProvider invalidPasswordProvider
     * @param string $value
     * @throws \Throwable
     */
    public function testExceptionOnInvalidPassword(string $value): void
    {
        $this->expectException(InvalidPassword::class);
        new PlainPassword($value);
    }
}
