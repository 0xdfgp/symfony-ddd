<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use App\Domain\DomainException;
use Throwable;

class PasswordNotMatch extends \Exception implements DomainException
{
    public function __construct(PlainPassword $plainPassword, int $code = 401, Throwable $previous = null)
    {
        parent::__construct("Invalid password: {$plainPassword->value()}", $code, $previous);
    }
}
