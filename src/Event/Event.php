<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event;

/**
 * Class Event
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class Event
{
    private IEventUser $sender;

    public function __construct(IEventUser $sender) {
        $this->sender = $sender;
    }

    public function getSender() : IEventUser
    {
        return $this->sender;
    }
}