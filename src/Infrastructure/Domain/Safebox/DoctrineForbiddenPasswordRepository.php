<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain\Safebox;

use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\ForbiddenPassword;
use App\Domain\Safebox\ForbiddenPasswordRepository;
use App\Infrastructure\Domain\Repository;

class DoctrineForbiddenPasswordRepository extends Repository implements ForbiddenPasswordRepository
{
    protected function className(): string
    {
        return ForbiddenPassword::class;
    }

    /**
     * Checks if exists a password in the repository.
     *
     * @param PlainPassword $password
     * @return bool
     */
    public function exists(PlainPassword $password): bool
    {
        return $this->repository()->findOneBy([
            'plainPassword' => $password->value()
        ]) !== null;
    }

    /**
     * @param ForbiddenPassword $password
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(ForbiddenPassword $password): void
    {
        $this->entityManager()->persist($password);
        $this->entityManager()->flush($password);
    }
}
