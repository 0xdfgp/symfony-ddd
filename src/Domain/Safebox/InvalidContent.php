<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use App\Domain\DomainException;
use Throwable;

class InvalidContent extends \Exception implements DomainException
{
    /**
     * InvalidName constructor.
     *
     * @param string         $value
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $value, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("'{$value} is an invalid content'", $code, $previous);
    }
}
