<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

interface SafeboxRepository
{
    /**
     * It generates a new Id.
     *
     * @return SafeboxId
     */
    public function newSafeboxId(): SafeboxId;

    /**
     * It generates a new Id.
     *
     * @return ItemId
     */
    public function newItemId(): ItemId;

    /**
     * It looks for a safe box by the given id.
     *
     * @param SafeboxId $id
     * @return Safebox|null
     */
    public function safeboxOfId(SafeboxId $id): ?Safebox;

    /**
     * It saves a Safebox in the repository.
     *
     * @param Safebox $safeBox
     */
    public function save(Safebox $safeBox): void;
}
