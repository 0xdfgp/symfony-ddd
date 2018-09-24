<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\SafeboxDtoAssembler;
use App\Domain\Safebox\SafeboxId;
use App\Domain\Safebox\SafeboxIsLocked;
use App\Domain\Safebox\SafeboxNotFound;
use App\Domain\Safebox\SafeboxRepository;

class GetASafeboxHandler
{
    /**
     * @var SafeboxRepository
     */
    private $repository;

    /**
     * @var SafeboxDtoAssembler
     */
    private $dtoAssembler;

    /**
     * CreateASafeboxHandler constructor.
     *
     * @param SafeboxRepository   $repository
     * @param SafeboxDtoAssembler $dtoAssembler
     */
    public function __construct(SafeboxRepository $repository, SafeboxDtoAssembler $dtoAssembler)
    {
        $this->repository   = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }

    /**
     * @param GetASafebox $query
     * @return array
     * @throws SafeboxNotFound
     * @throws SafeboxIsLocked
     */
    public function handle(GetASafebox $query): array
    {
        $id = new SafeboxId($query->safeboxId());

        $safebox = $this->repository->safeboxOfId($id);
        if ($safebox === null) {
            throw new SafeboxNotFound($id);
        }

        if ($safebox->locked()) {
            throw new SafeboxIsLocked($safebox->id());
        }

        return $this->dtoAssembler->write($safebox)->toArray();
    }
}
