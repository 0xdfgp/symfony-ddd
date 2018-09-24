<?php
declare(strict_types=1);

namespace App\Application\Service;

class OpenASafebox
{
    /**
     * @var string
     */
    private $safeboxId;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var int
     */
    private $expirationTime;

    /**
     * OpenASafebox constructor.
     *
     * @param string $safeboxId
     * @param string $plainPassword
     * @param int    $expirationTime
     */
    public function __construct(string $safeboxId, string $plainPassword, int $expirationTime)
    {
        $this->safeboxId = $safeboxId;
        $this->plainPassword = $plainPassword;
        $this->expirationTime = $expirationTime;
    }

    /**
     * @return string
     */
    public function safeboxId(): string
    {
        return $this->safeboxId;
    }

    /**
     * @return string
     */
    public function plainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @return int
     */
    public function expirationTime(): int
    {
        return $this->expirationTime;
    }
}
