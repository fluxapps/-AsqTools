<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;

use Fluxlabs\Assessment\Tools\DIC\CtrlTrait;
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

    /**
     * @var IAsqModule[] $commands
     */
    protected array $commands =[];

    protected EventQueue $event_queue;

    protected IAsqUI $ui;

    protected IObjectAccess $access;

    protected ?IStorageModule $data = null;

    /**
     * @var IAsqModule[]
     */
    protected array $modules = [];

    /**
     * @var IAsqObject[]
     */
    protected array $objects = [];

    public function __construct()
    {
        global $DIC;

        $this->event_queue = new EventQueue();
        $this->ui = new AsqUI();
        $this->access = new ObjectAccess($this);

        $this->event_queue->addUser($this->ui);
        $this->event_queue->addUser($this);
    }

    protected function addModule(IAsqModule $module) : void {
        $class = get_class($module);
        $this->modules[$class] = $module;
        $this->event_queue->addUser($module);

        if ($module instanceof IStorageModule) {
            if ($this->data !== null) {
                throw new Exception('Test object can only have one datasource');
            }

            $this->data = $module;
        }

        foreach ($module->getCommands() as $command) {
            $this->commands[$command] = $module;
        }
    }

    public function getModule(string $class) : IAsqModule
    {
        return $this->modules[$class];
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
        if (array_key_exists($command, $this->commands)) {
            $this->commands[$command]->executeCommand($command);
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
            $this->processForwardToCommandEvent($event->getCommand());
        }
    }

    private function processForwardToCommandEvent(string $command) : void
    {
        $this->redirectToCommand($command);
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