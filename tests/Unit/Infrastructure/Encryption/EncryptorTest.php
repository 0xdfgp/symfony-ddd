<?php
declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Encryption;

use App\Infrastructure\Encryptor\Encryptor;
use PHPUnit\Framework\TestCase;

class EncryptorTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testEncryptAndDecrypt(): void
    {
        $key = '31400300f7ef596dc4bf7366443375340d30e49630d91cfe6bb6be9b973fe'
            . '2f6df8a33d5a1013fad36d59a21d9da67c76e29248355fce08e347732755d4f1'
            . '7acbc29750146e67f1959e54029119b112809b516ee21613beffdb9ce6aa7f9f16c288abb0b';

        $encryptor = new Encryptor($key);

        $encrypted = $encryptor->encrypt('message');
        self::assertNotEquals('message', $encrypted);

        $message = $encryptor->decrypt($encrypted);
        self::assertEquals('message', $message);
    }
}
