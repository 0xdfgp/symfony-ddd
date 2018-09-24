<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

class ForbiddenPassword
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $plainPassword;

    public function __construct(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
}
