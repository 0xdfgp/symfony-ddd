<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

interface ForbiddenPasswordRepository
{
    /**
     * Checks if exists a password in the repository.
     *
     * @param PlainPassword $password
     * @return bool
     */
    public function exists(PlainPassword $password): bool;

    public function save(ForbiddenPassword $password): void;
}
