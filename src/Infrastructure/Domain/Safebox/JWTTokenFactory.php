<?php
declare(strict_types=1);

namespace App\Infrastructure\Domain\Safebox;

use App\Domain\Safebox\Safebox;
use App\Domain\Safebox\TokenFactory;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class JWTTokenFactory implements TokenFactory
{
    /**
     * @var JWTEncoderInterface
     */
    private $JWTEncoder;

    /**
     * JWTTokenFactory constructor.
     *
     * @param JWTEncoderInterface $JWTEncoder
     */
    public function __construct(JWTEncoderInterface $JWTEncoder)
    {
        $this->JWTEncoder = $JWTEncoder;
    }

    /**
     * @param Safebox $safebox
     * @param int     $expirationTime
     * @return string
     *
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function create(Safebox $safebox, int $expirationTime): string
    {
        return $this->JWTEncoder->encode([
            'username'  => $safebox->id()->value(),
            'exp'       => time() + $expirationTime
        ]);
    }
}
