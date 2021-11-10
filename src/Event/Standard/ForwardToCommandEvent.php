<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event\Standard;

use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;

/**
 * Class ForwardToCommandEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ForwardToCommandEvent extends Event
{
    private string $command;

    private ?array $parameters;

    public function __construct(IEventUser $sender, string $command, ?array $parameters = null)
    {
        parent::__construct($sender);

        $this->command = $command;
        $this->parameters = $parameters;
    }

    public function getCommand() : string
    {
        return $this->command;
    }

    public function getParameters() : ?array
    {
        return $this->parameters;
    }
}