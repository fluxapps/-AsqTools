<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules;

use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\Domain\Objects\ObjectConfiguration;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;

/**
 * Interface IAsqModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IAsqModule extends IEventUser
{
    /**
     * Return the class holding the configuration
     * Null means no configuration is needed
     *
     * @return ?string
     */
    public function getConfigClass() : ?string;

    /**
     * returns all commands provided by the module
     *
     * @return string[]
     */
    public function getCommands() : array;

    /**
     * executes a command in the module
     *
     * @param string $command
     */
    public function executeCommand(string $command): void;

    /**
     * Raises an event through the Test event queue
     *
     * @param Event $event
     */
    public function raiseEvent(Event $event) : void;

    /**
     * @param ObjectConfiguration $config
     * @return IAsqObject
     */
    public function createObject(ObjectConfiguration $config) : IAsqObject;
}