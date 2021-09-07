<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event;

/**
 * Interface IEventQueue
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IEventQueue
{
    function addUser(IEventUser $user) : void;

    function raiseEvent(Event $event) : void;
}