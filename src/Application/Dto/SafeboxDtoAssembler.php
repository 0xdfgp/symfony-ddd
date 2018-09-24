<?php
declare(strict_types=1);

namespace App\Application\Dto;

use App\Domain\Safebox\Item;
use App\Domain\Safebox\Safebox;

class SafeboxDtoAssembler
{
    /**
     * Converts a Safebox entity to a dto.
     *
     * @param Safebox $safebox
     * @return SafeboxDto
     */
    public function write(Safebox $safebox): SafeboxDto
    {
        return new SafeboxDto(
            $safebox->id()->value(),
            $safebox->name()->value(),
            array_map(function (Item $item) {
                return $item->content()->value();
            }, $safebox->items())
        );
    }
}
