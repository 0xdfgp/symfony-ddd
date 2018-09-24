<?php
declare(strict_types=1);

namespace App\Tests\Unit\Application\Service;

use App\Application\Service\AddASafeboxItem;
use App\Application\Service\AddASafeboxItemHandler;
use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\SafeboxNotFound;
use App\Domain\Safebox\SafeboxRepository;
use App\Tests\Suite\Mock\SafeboxRepositoryMock;
use App\Tests\Suite\Stub\ItemStub;
use App\Tests\Suite\Stub\SafeboxStub;
use PHPUnit\Framework\TestCase;

class AddASafeboxItemHandlerTest extends TestCase
{
    private $mockedRepository;

    private $handler;

    protected function setUp()
    {
        $this->mockedRepository = new SafeboxRepositoryMock($this->prophesize(SafeboxRepository::class));
        $this->handler          = new AddASafeboxItemHandler($this->mockedRepository->reveal());
    }

    /**
     * @throws \Throwable
     */
    public function testItemIsAdded(): void
    {
        $password = new PlainPassword('MySuperPassword00!');
        $safebox  = SafeboxStub::randomWithPlainPassword($password);
        $item     = ItemStub::randomWithSafebox($safebox);

        $expected = SafeboxStub::create(
            $safebox->id(),
            $safebox->name(),
            $password,
            [$item]
        );

        $this->mockedRepository
            ->shouldFind($safebox->id(), $safebox)
            ->shouldNewItemId($item->id())
            ->shouldSave($expected);

        $this->handler->handle(new AddASafeboxItem(
            $safebox->id()->value(),
            $item->content()->value()
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionOnMissingSafebox(): void
    {
        $this->expectException(SafeboxNotFound::class);

        $password = new PlainPassword('MySuperPassword00!');
        $safebox  = SafeboxStub::randomWithPlainPassword($password);
        $item     = ItemStub::randomWithSafebox($safebox);

        $this->mockedRepository
            ->shouldNotFind($safebox->id())
            ->saveShouldNotBeCalled();

        $this->handler->handle(new AddASafeboxItem(
            $safebox->id()->value(),
            $item->content()->value()
        ));
    }
}
