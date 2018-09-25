<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain\Safebox;

use App\Domain\Safebox\Content;
use App\Infrastructure\Encryptor\Encryptor;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class DoctrineContentType extends StringType
{
    private const NAME = 'encrypted_content';

    /**
     * @var Encryptor
     */
    private $encryptor;

    /**
     * @param Encryptor $encryptor
     */
    public function setEncryptor(Encryptor $encryptor): void
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @param Encryptor $encryptor
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function load(Encryptor $encryptor): void
    {
        if (! Type::hasType(static::NAME)) {
            Type::addType(static::NAME, static::class);
        }

        /** @var DoctrineContentType $type */
        $type = Type::getType(static::NAME);
        $type->setEncryptor($encryptor);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $decryptedValue = $this->encryptor->decrypt($value);

        return new Content($decryptedValue);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Content) {
            $value = $value->value();
        }

        return $this->encryptor->encrypt($value);
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     *
     * @todo Needed?
     */
    public function getName()
    {
        return self::NAME;
    }
}
