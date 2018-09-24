<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use App\Domain\DomainException;
use Throwable;

class SafeboxNotFound extends \Exception implements DomainException
{
    /**
     * SafeboxNotFound constructor.
     *
     * @param SafeboxId      $safeboxId
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(SafeboxId $safeboxId, int $code = 404, Throwable $previous = null)
    {
        parent::__construct("Safebox with id {$safeboxId} not found", $code, $previous);
    }
}
