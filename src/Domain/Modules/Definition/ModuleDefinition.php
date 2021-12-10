<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Definition;

use Fluxlabs\Assessment\Tools\Domain\Modules\IModuleDefinition;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

/**
 * Class ModuleDefinition
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ModuleDefinition implements  IModuleDefinition
{
    const NO_CONFIG = 'no_config';

    private string $config_factory_class;

    /**
     * @var CommandDefinition[]
     */
    private array $commands = [];

    /**
     * @var TabDefinition[]
     */
    private array $tabs = [];

    /**
     * @var string[]
     */
    private array $dependencies = [];

    /**
     * @param string $config_factory_class
     * @param CommandDefinition[] $commands
     * @param string[] $dependencies
     * @param TabDefinition[] $tabs
     */
    public function __construct(
        string $config_factory_class = self::NO_CONFIG,
        array $commands = [],
        array $dependencies = [],
        array $tabs = []
    ) {
        $this->config_factory_class = $config_factory_class;
        $this->dependencies = $dependencies;
        $this->commands = $commands;
        $this->tabs = $tabs;
    }

    public function getConfigFactory(): ?AbstractObjectFactory
    {
        if ($this->config_factory_class == self::NO_CONFIG) {
            return null;
        }

        global $DIC, $ASQDIC;

        return new $this->config_factory_class($DIC->language(), $DIC->ui(), $ASQDIC->asq()->ui());
    }

    /**
     * @return CommandDefinition[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * @return TabDefinition[]
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }
}