<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event\Standard;

use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;

/**
 * Class ExecuteCommandEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ExecuteCommandEvent extends Event
{
    private string $command;

    public function __construct(IEventUser $sender, string $command)
    {
        $this->command = $command;

        parent::__construct($sender);
    }

    public function getCommand() : string
    {
        return $this->command;
    }
}