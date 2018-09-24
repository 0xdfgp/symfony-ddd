<?php
declare(strict_types=1);

namespace App\Tests\Suite\Stub;

use App\Domain\Safebox\Content;
use App\Domain\Safebox\Item;
use App\Domain\Safebox\ItemId;
use App\Domain\Safebox\Safebox;
use Faker\Factory;

class ItemStub
{
    public static function create(ItemId $id, Content $content, Safebox $safebox): Item
    {
        return new Item($id, $content, $safebox);
    }

    public static function random(): Item
    {
        $faker = Factory::create();

        return self::create(
            new ItemId($faker->uuid),
            new Content($faker->paragraph),
            SafeboxStub::random()
        );
    }

    public static function randomWithSafebox(Safebox $safebox): Item
    {
        $faker = Factory::create();

        return self::create(
            new ItemId($faker->uuid),
            new Content($faker->paragraph),
            $safebox
        );
    }
}
