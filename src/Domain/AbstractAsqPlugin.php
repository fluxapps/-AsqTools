<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;

use Fluxlabs\Assessment\Tools\DIC\CtrlTrait;
use Fluxlabs\Assessment\Tools\DIC\UserTrait;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\CommandDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\IAccessModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\IAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\IStorageModule;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\Domain\Objects\ObjectConfiguration;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\EventQueue;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use Fluxlabs\Assessment\Tools\Event\Standard\ExecuteCommandEvent;
use Fluxlabs\Assessment\Tools\Event\Standard\ForwardToCommandEvent;
use Fluxlabs\Assessment\Tools\Event\Standard\RemoveObjectEvent;
use Fluxlabs\Assessment\Tools\Event\Standard\StoreObjectEvent;
use Fluxlabs\Assessment\Tools\UI\System\AsqUI;
use Fluxlabs\Assessment\Tools\UI\System\IAsqUI;
use ILIAS\DI\Exceptions\Exception;
use srag\asq\Application\Exception\AsqException;

/**
 * Interface Test
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
abstract class AbstractAsqPlugin implements IAsqPlugin, IEventUser
{
    use CtrlTrait;
    use UserTrait;

    /**
     * @var CommandDefinition[]
     */
    protected array $commands = [];

    /**
     * @var IAsqModule[]
     */
    protected array $command_map = [];

    /**
     * @var IAsqModule[]
     */
    protected array $transfers = [];

    protected EventQueue $event_queue;

    protected AsqUI $ui;

    protected IObjectAccess $access;

    protected ?IStorageModule $data = null;

    protected ?IAccessModule $access_module = null;

    protected ILIASReference $reference;

    /**
     * @var IAsqModule[]
     */
    protected array $modules = [];

    /**
     * @var IAsqObject[]
     */
    protected array $objects = [];

    public function __construct(ILIASReference $reference)
    {
        global $DIC;

        $this->reference = $reference;
        $this->event_queue = new EventQueue();
        $this->ui = new AsqUI();
        $this->access = new ObjectAccess($this);

        $this->event_queue->addUser($this->ui);
        $this->event_queue->addUser($this);
    }

    protected function addModule(string $class) : void {
        /** @var IAsqModule $module */
        $module = new $class($this->event_queue, $this->access);
        $this->modules[$class] = $module;
        $this->event_queue->addUser($module);

        if ($module instanceof IStorageModule) {
            if ($this->data !== null) {
                throw new AsqException('Plugin object can only have one datasource');
            }

            $this->data = $module;
        }

        if ($module instanceof IAccessModule) {
            if ($this->access_module !== null) {
                throw new AsqException('Plugin object can only have one access module');
            }

            $this->access_module = $module;
        }

        $module_definition = $module->getModuleDefinition();

        foreach ($module_definition->getCommands() as $command) {
            if (array_key_exists($command->getName(), $this->commands)) {
                throw new AsqException(
                    sprintf('Command "%s" defined multiple times', $command->getName())
                );
            }

            $this->commands[$command->getName()] = $command;
            $this->command_map[$command->getName()] = $module;
        }

        foreach ($module_definition->getTabs() as $tab) {
            $this->ui->addTab($tab);
        }

        foreach ($module_definition->getExternals() as $external) {
            $this->transfers[strtolower($external)] = $module;
        }
    }

    public function getModule(string $class) : IAsqModule
    {
        return $this->modules[$class];
    }

    public function getStorage(): IStorageModule
    {
        return $this->data;
    }

    public function getReference() : ILIASReference
    {
        return $this->reference;
    }

    public function getModulesOfType(string $class) : array
    {
        $matches = [];

        foreach ($this->modules as $key => $module) {
            if (in_array($class, class_implements($module))) {
                $matches[$key] = $module;
            }
        }

        return $matches;
    }

    public function getObject(string $key): IAsqObject
    {
        if (!array_key_exists($key, $this->objects)) {
            /** @var ObjectConfiguration $config */
            $config = $this->data->getConfiguration($key);

            $this->objects[$key] = $this->getModule($config->moduleName())->createObject($config);
        }

        return $this->objects[$key];
    }

    public function getObjectsOfModules(array $modules) : array
    {
        $module_types = array_map(function($module) {
            return get_class($module);
        }, $modules);

        $objects = [];
        foreach ($this->data->getConfigurations() as $key => $configuration)
        {
            if (! in_array(ObjectConfiguration::class, class_parents($configuration))) {
                continue;
            }

            /** @var $configuration ObjectConfiguration */
            if (in_array($configuration->moduleName(), $module_types)) {
                $objects[] = $this->getObject($key);
            }
        }

        return $objects;
    }

    public function executeCommand(string $command) : void
    {
        if (array_key_exists($command, $this->command_map)) {
            $definition = $this->commands[$command];

            if ($this->access_module !== null && !$this->access_module->hasAccess($this->getCurrentUser(), $definition->getAccessLevel())) {
                throw new AsqException(
                    sprintf(
                        'Access to command "%s" with access level "%s" denied for current user',
                        $definition->getName(),
                        $definition->getAccessLevel()
                    )
                );
            }

            $this->command_map[$command]->executeCommand($definition);
            $this->ui->setActiveTab($definition->getTab());
        }
    }

    function handleTransfer(string $next): void
    {
        $next_key = strtolower($next);

        if (array_key_exists($next_key, $this->transfers)) {
            $this->transfers[$next_key]->executeTransfer($next_key);
        }
    }

    public function ui() : IAsqUI
    {
        return $this->ui;
    }

    public function processEvent(Event $event) : void
    {
        if (get_class($event) === StoreObjectEvent::class) {
            $this->processStoreObjectEvent($event->getObject());
        }

        if (get_class($event) === RemoveObjectEvent::class) {
            $this->processRemoveObjectEvent($event->getObject());
        }

        if (get_class($event) === ExecuteCommandEvent::class) {
            $this->executeCommand($event->getCommand());
        }

        if (get_class($event) === ForwardToCommandEvent::class) {
            $this->processForwardToCommandEvent($event->getCommand(), $event->getParameters());
        }
    }

    private function processForwardToCommandEvent(string $command, ?array $parameters) : void
    {
        $this->redirectToCommand($command, $parameters);
    }

    public function processStoreObjectEvent(IAsqObject $object) : void
    {
        $this->objects[$object->getKey()] = $object;
        $this->data->setConfiguration($object->getKey(), $object->getConfiguration());
        $this->data->save();
    }

    public function processRemoveObjectEvent(IAsqObject $object) : void
    {
        unset($this->objects[$object->getKey()]);
        $this->data->removeConfiguration($object->getKey());
        $this->data->save();
    }

    abstract public static function getInitialCommand() : string;
}