<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\SafeboxDtoAssembler;
use App\Domain\Safebox\InvalidPassword;
use App\Domain\Safebox\Name;
use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\ForbiddenPasswordRepository;
use App\Domain\Safebox\Safebox;
use App\Domain\Safebox\SafeboxRepository;

class CreateASafeboxHandler
{
    /**
     * @var SafeboxRepository
     */
    private $repository;

    /**
     * @var ForbiddenPasswordRepository
     */
    private $forbiddenPasswordRepository;

    /**
     * @var SafeboxDtoAssembler
     */
    private $dtoAssembler;

    /**
     * CreateASafeboxHandler constructor.
     *
     * @param SafeboxRepository           $repository
     * @param ForbiddenPasswordRepository $forbiddenPasswordRepository
     * @param SafeboxDtoAssembler         $dtoAssembler
     */
    public function __construct(
        SafeboxRepository $repository,
        ForbiddenPasswordRepository $forbiddenPasswordRepository,
        SafeboxDtoAssembler $dtoAssembler
    ) {
        $this->repository                  = $repository;
        $this->forbiddenPasswordRepository = $forbiddenPasswordRepository;
        $this->dtoAssembler                = $dtoAssembler;
    }

    /**
     * @param CreateASafebox $command
     * @return array
     * @throws \App\Domain\Safebox\InvalidPassword
     * @throws \App\Domain\Safebox\InvalidName
     */
    public function handle(CreateASafebox $command): array
    {
        $name = new Name($command->name());
        $password = new PlainPassword($command->password());

        if ($this->forbiddenPasswordRepository->exists($password)) {
            throw new InvalidPassword($password->value());
        }

        $safebox = new Safebox(
            $this->repository->newSafeboxId(),
            $name,
            $password
        );

        $this->repository->save($safebox);

        return $this->dtoAssembler->write($safebox)->toArray();
    }
}
