<?php
declare(strict_types=1);

namespace App\Tests\Unit\Application\Service;

use App\Application\Dto\SafeboxDtoAssembler;
use App\Application\Service\CreateASafebox;
use App\Application\Service\CreateASafeboxHandler;
use App\Domain\DomainException;
use App\Domain\Safebox\ForbiddenPasswordRepository;
use App\Domain\Safebox\InvalidPassword;
use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\Safebox;
use App\Domain\Safebox\SafeboxId;
use App\Domain\Safebox\SafeboxRepository;
use App\Tests\Suite\Mock\ForbiddenPasswordRepositoryMock;
use App\Tests\Suite\Mock\SafeboxRepositoryMock;
use App\Tests\Suite\Stub\SafeboxStub;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class CreateASafeBoxHandlerTest extends TestCase
{
    private $mockedRepository;

    private $mockedProhibitedPasswordRepository;

    private $handler;

    protected function setUp()
    {
        $this->mockedRepository = new SafeboxRepositoryMock(
            $this->prophesize(SafeboxRepository::class)
        );

        $this->mockedProhibitedPasswordRepository = new ForbiddenPasswordRepositoryMock(
            $this->prophesize(ForbiddenPasswordRepository::class)
        );

        $this->handler = new CreateASafeboxHandler(
            $this->mockedRepository->reveal(),
            $this->mockedProhibitedPasswordRepository->reveal(),
            new SafeboxDtoAssembler()
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSafeBoxCreation(): void
    {
        $password   = 'MySuperPassword00!';
        $safebox = SafeboxStub::randomWithPlainPassword(new PlainPassword($password));

        $this->mockedProhibitedPasswordRepository
            ->shouldNotExist(new PlainPassword($password));

        $this->mockedRepository
            ->shouldNewSafeboxId($safebox->id())
            ->shouldSave($safebox);

        $safeBox = $this->handler->handle(new CreateASafebox(
            $safebox->name()->value(),
            $password
        ));

        self::assertEquals($safebox->name()->value(), $safeBox['name']);
        self::assertEquals($safebox->id()->value(), $safeBox['id']);
    }

    public function invalidDataProvider(): array
    {
        return [
            ['', 'xsd332kfmvccw'],
            ['valid-name', 'qwerty'],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     * @param string $name
     * @param string $password
     * @throws \Throwable
     */
    public function testExceptionOnInvalidParameters(string $name, string $password): void
    {
        $this->expectException(DomainException::class);

        $this->mockedRepository
            ->saveShouldNotBeCalled();

        $this->handler->handle(new CreateASafebox($name, $password));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionOnReceiveAnInsecurePassword(): void
    {
        $this->expectException(InvalidPassword::class);

        $faker    = Factory::create();
        $name     = $faker->name;
        $password = 'MySuperPassword00!';

        $this->mockedProhibitedPasswordRepository
            ->shouldExist(new PlainPassword($password));

        $this->mockedRepository
            ->saveShouldNotBeCalled();

        $this->handler->handle(new CreateASafebox($name, $password));
    }
}
