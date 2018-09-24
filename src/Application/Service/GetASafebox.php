<?php
declare(strict_types=1);

namespace App\Application\Service;

class GetASafebox
{
    /**
     * @var string
     */
    private $safeboxId;

    public function __construct(string $safeboxId)
    {
        $this->safeboxId = $safeboxId;
    }

    /**
     * @return string
     */
    public function safeboxId(): string
    {
        return $this->safeboxId;
    }
}
