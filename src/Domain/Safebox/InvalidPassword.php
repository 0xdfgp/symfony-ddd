<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use App\Domain\DomainException;
use Throwable;

class InvalidPassword extends \Exception implements DomainException
{
    /**
     * InvalidPassword constructor.
     *
     * @param string         $password
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $password, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("'{$password}' is an invalid password", $code, $previous);
    }
}
