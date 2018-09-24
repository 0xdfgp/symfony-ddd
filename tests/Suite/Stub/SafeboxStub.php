<?php
declare(strict_types=1);

namespace App\Tests\Suite\Stub;

use App\Domain\Safebox\Name;
use App\Domain\Safebox\PlainPassword;
use App\Domain\Safebox\Safebox;
use App\Domain\Safebox\SafeboxId;
use Faker\Factory;

class SafeboxStub
{
    public static function create(SafeboxId $id, Name $name, PlainPassword $password, array $items = []): Safebox
    {
        return new Safebox($id, $name, $password, $items);
    }

    public static function random(): Safebox
    {
        $faker = Factory::create();

        return self::create(
            new SafeboxId($faker->uuid),
            new Name($faker->name),
            new PlainPassword($faker->password)
        );
    }

    public static function randomLocked(): Safebox
    {
        $faker = Factory::create();

        $safebox = self::create(
            new SafeboxId($faker->uuid),
            new Name($faker->name),
            new PlainPassword($faker->password)
        );

        $safebox = self::silentPasswordAttempt($safebox, new PlainPassword('invalid'));
        $safebox = self::silentPasswordAttempt($safebox, new PlainPassword('invalid'));
        $safebox = self::silentPasswordAttempt($safebox, new PlainPassword('invalid'));
        $safebox = self::silentPasswordAttempt($safebox, new PlainPassword('invalid'));

        return $safebox;
    }

    private static function silentPasswordAttempt(Safebox $safebox, PlainPassword $plainPassword): Safebox
    {
        try {
            $safebox->attemptPassword($plainPassword);
        } finally {
            return $safebox;
        }
    }

    public static function randomWithItems(array $items): Safebox
    {
        $faker = Factory::create();

        return self::create(
            new SafeboxId($faker->uuid),
            new Name($faker->name),
            new PlainPassword($faker->password),
            $items
        );
    }

    public static function randomWithPlainPassword(PlainPassword $plainPassword): Safebox
    {
        $faker = Factory::create();

        return self::create(
            new SafeboxId($faker->uuid),
            new Name($faker->name),
            $plainPassword
        );
    }
}
