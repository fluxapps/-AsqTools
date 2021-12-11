<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules;

use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\CommandDefinition;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\Domain\Objects\ObjectConfiguration;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

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
     * Gets the Module definition, so the plugin is able to load the module
     *
     * @return IModuleDefinition
     */
    public function getModuleDefinition() : IModuleDefinition;

    /**
     * executes a command in the module
     *
     * @param CommandDefinition $command
     */
    public function executeCommand(CommandDefinition $command): void;

    /**
     * Hadles transfer to extenal class
     *
     * @param string $transfer
     */
    public function executeTransfer(string $transfer) : void;

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