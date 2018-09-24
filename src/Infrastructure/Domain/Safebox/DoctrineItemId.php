<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain\Safebox;

use App\Domain\Safebox\ItemId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Uuid;

class DoctrineItemId extends UuidBinaryOrderedTimeType
{
    /**
     * @param null|\Ramsey\Uuid\UuidInterface|string $value
     * @param AbstractPlatform                       $platform
     * @return DoctrineSafeboxId|mixed|null|\Ramsey\Uuid\UuidInterface|string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $value = parent::convertToPHPValue($value, $platform);
        if ($value instanceof Uuid) {
            $value = $value->toString();
        }

        return new ItemId($value);
    }
}
