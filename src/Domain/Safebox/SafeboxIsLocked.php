<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use App\Domain\DomainException;
use Throwable;

class SafeboxIsLocked extends \Exception implements DomainException
{
    public function __construct(SafeboxId $safeboxId, int $code = 423, Throwable $previous = null)
    {
        parent::__construct("Safebox {$safeboxId} is locked", $code, $previous);
    }
}
