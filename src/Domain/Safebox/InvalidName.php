<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use App\Domain\DomainException;
use Throwable;

class InvalidName extends \Exception implements DomainException
{
    /**
     * InvalidName constructor.
     *
     * @param string         $name
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $name, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("'{$name} is an invalid name'", $code, $previous);
    }
}
