<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

class Item
{
    /**
     * @var ItemId
     */
    private $id;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var Safebox
     */
    private $safebox;

    /**
     * Item constructor.
     *
     * @param ItemId  $id
     * @param Content $content
     * @param Safebox $safebox
     */
    public function __construct(ItemId $id, Content $content, Safebox $safebox)
    {
        $this->id      = $id;
        $this->content = $content;
        $this->safebox = $safebox;
    }

    /**
     * @return ItemId
     */
    public function id(): ItemId
    {
        return $this->id;
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return $this->content;
    }
}
