<?php
declare(strict_types=1);

namespace App\Tests\Unit\Application\Service;

use App\Application\Dto\SafeboxDtoAssembler;
use App\Application\Service\GetASafebox;
use App\Application\Service\GetASafeboxHandler;
use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\SafeboxIsLocked;
use App\Domain\Safebox\SafeboxNotFound;
use App\Domain\Safebox\SafeboxRepository;
use App\Tests\Suite\Mock\SafeboxRepositoryMock;
use App\Tests\Suite\Stub\ItemStub;
use App\Tests\Suite\Stub\SafeboxStub;
use PHPUnit\Framework\TestCase;

class GetASafeboxHandlerTest extends TestCase
{
    private $mockedRepository;

    private $handler;

    protected function setUp()
    {
        $this->mockedRepository = new SafeboxRepositoryMock($this->prophesize(SafeboxRepository::class));
        $this->handler          = new GetASafeboxHandler(
            $this->mockedRepository->reveal(),
            new SafeboxDtoAssembler()
        );
    }

    /**
     * @throws \Throwable
     */
    public function testGetASafebox(): void
    {
        $item = ItemStub::random();

        $safebox  = SafeboxStub::randomWithItems([$item]);

        $this->mockedRepository
            ->shouldFind($safebox->id(), $safebox);

        $safebox = $this->handler->handle(new GetASafebox($safebox->id()->value()));

        self::assertCount(1, $safebox['items']);
        self::assertEquals($item->content()->value(), $safebox['items'][0]);
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionOnLockedSafebox(): void
    {
        $this->expectException(SafeboxIsLocked::class);

        $safebox  = SafeboxStub::randomLocked();

        $this->mockedRepository
            ->shouldFind($safebox->id(), $safebox);

        $this->handler->handle(new GetASafebox($safebox->id()->value()));

    }

    /**
     * @throws \Throwable
     */
    public function testExceptionOnMissingSafebox(): void
    {
        $this->expectException(SafeboxNotFound::class);

        $safebox  = SafeboxStub::random();

        $this->mockedRepository
            ->shouldNotFind($safebox->id());

        $this->handler->handle(new GetASafebox($safebox->id()->value()));
    }
}
