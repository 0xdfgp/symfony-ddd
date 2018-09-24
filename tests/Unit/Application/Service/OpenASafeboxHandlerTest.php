<?php
declare(strict_types=1);

namespace App\Tests\Unit\Application\Service;

use App\Application\Service\OpenASafebox;
use App\Application\Service\OpenASafeboxHandler;
use App\Domain\Safebox\PasswordNotMatch;
use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\SafeboxNotFound;
use App\Domain\Safebox\SafeboxRepository;
use App\Domain\Safebox\TokenFactory;
use App\Tests\Suite\Mock\SafeboxRepositoryMock;
use App\Tests\Suite\Mock\TokenFactoryMock;
use App\Tests\Suite\Stub\SafeboxStub;
use PHPUnit\Framework\TestCase;

class OpenASafeboxHandlerTest extends TestCase
{
    private $mockedRepository;

    private $mockedTokenFactory;

    private $handler;

    protected function setUp()
    {
        $this->mockedRepository   = new SafeboxRepositoryMock($this->prophesize(SafeboxRepository::class));
        $this->mockedTokenFactory = new TokenFactoryMock($this->prophesize(TokenFactory::class));
        $this->handler            = new OpenASafeboxHandler(
            $this->mockedRepository->reveal(),
            $this->mockedTokenFactory->reveal()
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSafeboxIsOpen(): void
    {
        $password ='MySuperPassword00!';
        $safebox  = SafeboxStub::randomWithPlainPassword(new PlainPassword($password));
        $expirationTime = 3600;
        $expected = 'my-random-token';

        $this->mockedRepository
            ->shouldFind($safebox->id(), $safebox)
            ->shouldSave($safebox);

        $this->mockedTokenFactory
            ->shouldCreate($safebox, $expirationTime, $expected);

        $token = $this->handler->handle(new OpenASafebox(
            $safebox->id()->value(),
            $password,
            $expirationTime
        ));

        self::assertEquals($expected, $token);
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionOnInvalidPassword(): void
    {
        $this->expectException(PasswordNotMatch::class);

        $safebox = SafeboxStub::random();

        $this->mockedRepository
            ->shouldFind($safebox->id(), $safebox)
            ->shouldSave($safebox);

        $this->handler->handle(new OpenASafebox(
            $safebox->id()->value(),
            'not-valid',
            3600
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionOnMissingSafebox(): void
    {
        $this->expectException(SafeboxNotFound::class);

        $safebox = SafeboxStub::random();

        $this->mockedRepository
            ->shouldNotFind($safebox->id())
            ->saveShouldNotBeCalled();

        $this->handler->handle(new OpenASafebox(
            $safebox->id()->value(),
            'it does not matters now',
            3600
        ));
    }
}
