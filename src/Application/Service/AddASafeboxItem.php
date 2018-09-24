<?php
declare(strict_types=1);

namespace App\Application\Service;

class AddASafeboxItem
{
    /**
     * @var string
     */
    private $safeboxId;

    /**
     * @var string
     */
    private $item;

    /**
     * AASafeboxItem constructor.
     *
     * @param string $safeboxId
     * @param string $item
     */
    public function __construct(string $safeboxId, string $item)
    {
        $this->safeboxId = $safeboxId;
        $this->item = $item;
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
    public function item(): string
    {
        return $this->item;
    }
}
