<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain;

use Fluxlabs\Assessment\Tools\Domain\Modules\IAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;

/**
 * Interface IObjectAccess
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IObjectAccess
{
    /**
     * Gets testModule of given Class
     *
     * @param string $class
     * @return IAsqModule
     */
    public function getModule(string $class) : IAsqModule;

    /**
     * Gets an object from the Test
     *
     * @param string $key
     * @return IAsqObject
     */
    public function getObject(string $key) : IAsqObject;

    /**
     * Gets all objects of a type defined in ITestModule
     *
     * @param string $type
     * @return IAsqObject[]
     */
    public function getObjectsOfType(string $type) : array;
}