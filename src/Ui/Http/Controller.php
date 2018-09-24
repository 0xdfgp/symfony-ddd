<?php
declare(strict_types=1);

namespace App\Ui\Http;

use League\Tactician\CommandBus;

abstract class Controller
{
    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * Controller constructor.
     *
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }
}
