<?php
declare(strict_types=1);

namespace App\Tests\Suite\Mock;

use App\Domain\Safebox\ItemId;
use App\Domain\Safebox\Safebox;
use App\Domain\Safebox\SafeboxId;
use Prophecy\Argument;

class SafeboxRepositoryMock extends Mock
{
    public function shouldNewSafeboxId(SafeboxId $id): self
    {
        $this->prophecy
            ->newSafeboxId()
            ->willReturn($id)
            ->shouldBeCalled();

        return $this;
    }

    public function shouldNewItemId(ItemId $id): self
    {
        $this->prophecy
            ->newItemId()
            ->willReturn($id)
            ->shouldBeCalled();

        return $this;
    }

    public function shouldSave(Safebox $safebox): self
    {
        $this
            ->prophecy
            ->save(Argument::that(function (Safebox $value) use ($safebox) {
                return
                    $value->id()->equals($safebox->id()) &&
                    $value->name()->equals($safebox->name()) &&
                    $value->items() == $safebox->items();
            }))
            ->shouldBeCalled();

        return $this;
    }

    public function saveShouldNotBeCalled(): self
    {
        $this
            ->prophecy
            ->save(Argument::type(Safebox::class))
            ->shouldNotBeCalled();

        return $this;
    }

    public function shouldFind(SafeboxId $id, Safebox $expected): self
    {
        $this
            ->prophecy
            ->safeboxOfId($id)
            ->willReturn($expected)
            ->shouldBeCalled();

        return $this;
    }

    public function shouldNotFind(SafeboxId $id): self
    {
        $this
            ->prophecy
            ->safeboxOfId($id)
            ->willReturn(null)
            ->shouldBeCalled();

        return $this;
    }
}
