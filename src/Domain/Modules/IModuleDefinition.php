<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules;

use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\CommandDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\ExternalDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\TabDefinition;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\Domain\Objects\ObjectConfiguration;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

/**
 * Interface IModuleDefinition
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IModuleDefinition
{
    /**
     * Return the configuration factory for the module
     * Null means no configuration is needed
     *
     * @return ?AbstractObjectFactory
     */
    public function getConfigFactory() : ?AbstractObjectFactory;

    /**
     * returns all commands provided by the module
     *
     * @return CommandDefinition[]
     */
    public function getCommands() : array;

    /**
     * All the Tabs the module generates
     *
     * @return TabDefinition[]
     */
    public function getTabs() : array;

    /**
     * Gets all the modules the module is dependent on
     * Dependency on storage module is inplicit and has not to be listed seperately
     *
     * @return array
     */
    public function getDependencies() : array;
}