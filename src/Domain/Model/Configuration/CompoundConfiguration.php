<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Model\Configuration;

use Fluxlabs\CQRS\Aggregate\AbstractValueObject;

/**
 * Class CompoundConfiguration
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class CompoundConfiguration extends AbstractValueObject
{
    /**
     * @var AbstractValueObject[]
     */
    protected array $configurations = [];

    public function setConfiguration(string $key, AbstractValueObject $config) : void
    {
        $this->configurations[$key] = $config;
    }

    public function getConfiguration(string $key) : ?AbstractValueObject
    {
        if (array_key_exists($key, $this->configurations)) {
            return $this->configurations[$key];
        }
        else {
            return null;
        }
    }
}