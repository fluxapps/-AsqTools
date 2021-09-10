<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;


use Fluxlabs\Assessment\Tools\Domain\Modules\IAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\UI\System\IAsqUI;

/**
 * Interface Object
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IAsqPlugin
{
    /**
     * Gets objectModule of given Class
     *
     * @param string $class
     * @return IAsqModule
     */
    function getModule(string $class) : IAsqModule;

    /**
     * Gets an object from the AsqPlugin
     *
     * @param string $key
     * @return IAsqObject
     */
    function getObject(string $key) : IAsqObject;

    /**
     * Gets all objects of modules
     *
     * @param IAsqModule[] $modules
     * @return IAsqObject[]
     */
    function getObjectsOfModules(array $modules) : array;

    /**
     * Executes a command in the AsqPlugin
     *
     * @param string $command
     */
    function executeCommand(string $command) : void;

    /**
     * Handles transfer to another ILIAS module
     *
     * @param string $nextClass
     */
    function handleTransfer(string $nextClass) : void;

    /**
     * Gets access to the ui module of the Plugin
     *
     * @return IAsqUI
     */
    function ui() : IAsqUI;
}