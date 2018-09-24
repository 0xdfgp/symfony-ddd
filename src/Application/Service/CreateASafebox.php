<?php
declare(strict_types=1);

namespace App\Application\Service;

class CreateASafebox
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $password;

    /**
     * CreateASafeBox constructor.
     *
     * @param string $name
     * @param string $password
     */
    public function __construct(string $name, string $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
