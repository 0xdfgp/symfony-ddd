<?php
declare(strict_types=1);

namespace App\Application\Dto;

class SafeboxDto
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $items;

    /**
     * SafeboxDto constructor.
     *
     * @param string   $id
     * @param string   $name
     * @param string[] $items
     */
    public function __construct(string $id, string $name, array $items)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'items' => $this->items
        ];
    }
}
