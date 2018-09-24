<?php
declare(strict_types=1);

namespace App\Tests\Suite\Mock;

use App\Domain\Safebox\PlainPassword;

class ForbiddenPasswordRepositoryMock extends Mock
{
    public function shouldExist(PlainPassword $password): self
    {
        $this->prophecy
            ->exists($password)
            ->willReturn(true)
            ->shouldBeCalled();

        return $this;
    }

    public function shouldNotExist(PlainPassword $password): self
    {
        $this->prophecy
            ->exists($password)
            ->willReturn(false)
            ->shouldBeCalled();

        return $this;
    }
}
