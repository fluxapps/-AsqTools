<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event;

/**
 * Interface IEventUser
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IEventUser
{
    function processEvent(Event $event) : void;
}