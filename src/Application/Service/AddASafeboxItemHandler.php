<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Safebox\Content;
use App\Domain\Safebox\SafeboxId;
use App\Domain\Safebox\SafeboxNotFound;
use App\Domain\Safebox\SafeboxRepository;

class AddASafeboxItemHandler
{
    /**
     * @var SafeboxRepository
     */
    private $repository;

    public function __construct(SafeboxRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AddASafeboxItem $command
     * @throws \App\Domain\Safebox\InvalidContent
     * @throws SafeboxNotFound
     */
    public function handle(AddASafeboxItem $command): void
    {
        $safeboxId = new SafeboxId($command->safeboxId());
        $content = new Content($command->item());

        $safebox = $this->repository->safeboxOfId($safeboxId);
        if ($safebox === null) {
            throw new SafeboxNotFound($safeboxId);
        }

        $safebox->addContent(
            $this->repository->newItemId(),
            $content
        );

        $this->repository->save($safebox);
    }
}
