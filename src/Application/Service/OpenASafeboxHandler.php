<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\SafeboxId;
use App\Domain\Safebox\SafeboxNotFound;
use App\Domain\Safebox\SafeboxRepository;
use App\Domain\Safebox\TokenFactory;

class OpenASafeboxHandler
{
    /**
     * @var SafeboxRepository
     */
    private $repository;

    /**
     * @var TokenFactory
     */
    private $tokenFactory;

    /**
     * OpenASafeboxHandler constructor.
     *
     * @param SafeboxRepository $repository
     * @param TokenFactory      $tokenFactory
     */
    public function __construct(SafeboxRepository $repository, TokenFactory $tokenFactory)
    {
        $this->repository = $repository;
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * @param OpenASafebox $command
     * @return string
     *
     * @throws SafeboxNotFound
     * @throws \App\Domain\Safebox\InvalidPassword
     * @throws \App\Domain\Safebox\PasswordNotMatch
     * @throws \App\Domain\Safebox\SafeboxIsLocked
     */
    public function handle(OpenASafebox $command): string
    {
        $id = new SafeboxId($command->safeboxId());
        $password = new PlainPassword($command->plainPassword());

        $safebox = $this->repository->safeboxOfId($id);
        if ($safebox === null) {
            throw new SafeboxNotFound($id);

        }

        try {
            $safebox->attemptPassword($password);
        } finally {
            $this->repository->save($safebox);
        }

        return $this->tokenFactory->create($safebox, $command->expirationTime());
    }
}
