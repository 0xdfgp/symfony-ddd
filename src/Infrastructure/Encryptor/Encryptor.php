<?php
declare(strict_types=1);

namespace App\Infrastructure\Encryptor;

use ParagonIE\Halite\HiddenString;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\Halite\Symmetric\Crypto;

class Encryptor
{
    /**
     * @var \ParagonIE\Halite\Symmetric\EncryptionKey
     */
    private $key;

    /**
     * Encryptor constructor.
     *
     * @param string $key
     * @throws \ParagonIE\Halite\Alerts\CannotPerformOperation
     */
    public function __construct(string $key)
    {
        $this->key = KeyFactory::importEncryptionKey(new HiddenString($key));;
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt(string $value): string
    {
        return Crypto::encrypt(new HiddenString($value), $this->key);
    }

    /**
     * @param string $value
     * @return string
     * @throws \ParagonIE\Halite\Alerts\InvalidMessage
     */
    public function decrypt(string $value): string
    {
        return Crypto::decrypt($value, $this->key)->getString();
    }
}
