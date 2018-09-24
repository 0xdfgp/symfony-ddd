<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

interface TokenFactory
{
    /**
     * @param Safebox $safebox
     * @param int     $expirationTime
     * @return string
     */
    public function create(Safebox $safebox, int $expirationTime): string;
}
