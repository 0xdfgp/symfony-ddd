<?php
declare(strict_types=1);

namespace App\Tests\Suite\Mock;

use App\Domain\Safebox\Safebox;

class TokenFactoryMock extends Mock
{
    public function shouldCreate(Safebox $safebox, int $expirationTime, string $expected): self
    {
        $this->prophecy
            ->create($safebox, $expirationTime)
            ->willReturn($expected)
            ->shouldBeCalled();

        return $this;
    }
}
