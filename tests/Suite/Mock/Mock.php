<?php
declare(strict_types=1);

namespace App\Tests\Suite\Mock;

use Prophecy\Prophecy\ObjectProphecy;

class Mock
{
    /**
     * @var ObjectProphecy
     */
    protected $prophecy;

    public function __construct(ObjectProphecy $prophecy)
    {
        $this->prophecy = $prophecy;
    }

    public function reveal()
    {
        return $this->prophecy->reveal();
    }
}
