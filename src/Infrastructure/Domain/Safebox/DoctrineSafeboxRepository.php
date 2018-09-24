<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain\Safebox;

use App\Domain\Safebox\ItemId;
use App\Domain\Safebox\Safebox;
use App\Domain\Safebox\SafeboxId;
use App\Domain\Safebox\SafeboxRepository;
use App\Infrastructure\Domain\Repository;
use Ramsey\Uuid\Uuid;

class DoctrineSafeboxRepository extends Repository implements SafeboxRepository
{
    protected function className(): string
    {
        return Safebox::class;
    }

    /**
     * It generates a new Id.
     *
     * @return SafeboxId
     * @throws \Exception
     */
    public function newSafeboxId(): SafeboxId
    {
        return new SafeboxId(Uuid::getFactory()->uuid1()->toString());
    }

    /**
     * It generates a new Id.
     *
     * @return ItemId
     * @throws \Exception
     */
    public function newItemId(): ItemId
    {
        return new ItemId(Uuid::getFactory()->uuid1()->toString());
    }

    /**
     * It looks for a safe box by the given id.
     *
     * @param SafeboxId $id
     * @return Safebox|null
     */
    public function safeboxOfId(SafeboxId $id): ?Safebox
    {
        return $this->repository()->find($id);
    }

    /**
     * It saves a Safebox in the repository.
     *
     * @param Safebox $safeBox
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Safebox $safeBox): void
    {
        $this->entityManager()->persist($safeBox);
        $this->entityManager()->flush($safeBox);
    }
}
