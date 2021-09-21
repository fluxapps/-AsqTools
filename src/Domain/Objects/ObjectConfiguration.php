<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Objects;

use Fluxlabs\CQRS\Aggregate\AbstractValueObject;

/**
 * Abstract Class ObjectConfiguration
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
abstract class ObjectConfiguration extends AbstractValueObject
{
    /**
     * The name of the module that processes this configuration into and object
     *
     * @return string
     */
    abstract public function moduleName() : string;
}