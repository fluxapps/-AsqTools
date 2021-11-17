<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Model;

use Fluxlabs\Assessment\Tools\Domain\Event\ObjectConfigurationRemovedEvent;
use Fluxlabs\Assessment\Tools\Domain\Event\ObjectConfigurationSetEvent;
use Fluxlabs\CQRS\Aggregate\AbstractAggregateRoot;
use DateTimeImmutable;
use Fluxlabs\CQRS\Aggregate\AbstractValueObject;

/**
 * Abstract Class PluginAggregateRoot
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
abstract class PluginAggregateRoot extends AbstractAggregateRoot
{
    protected ?array $configurations = [];

    public function setConfiguration(
        AbstractValueObject $configuration,
        string $configuration_for) : void
    {
        if (! array_key_exists($configuration_for, $this->configurations) ||
            ! AbstractValueObject::isNullableEqual($configuration, $this->configurations[$configuration_for])) {
            $this->ExecuteEvent(
                new ObjectConfigurationSetEvent(
                    $this->aggregate_id,
                    new DateTimeImmutable(),
                    $configuration,
                    $configuration_for
                )
            );
        }
    }

    protected function applyObjectConfigurationSetEvent(ObjectConfigurationSetEvent $event) : void
    {
        $this->configurations[$event->getConfigFor()] = $event->getConfig();
    }

    public function removeConfiguration(
        string $configuration_for) : void
    {
        if (array_key_exists($configuration_for, $this->configurations))
        {
            $this->ExecuteEvent(
                new ObjectConfigurationRemovedEvent(
                    $this->aggregate_id,
                    new DateTimeImmutable(),
                    $configuration_for
                )
            );
        }
    }

    protected function applyObjectConfigurationRemovedEvent(ObjectConfigurationRemovedEvent $event) : void
    {
        unset($this->configurations[$event->getConfigFor()]);
    }

    public function getConfigurations() : array
    {
        return $this->configurations;
    }

    public function getConfiguration(string $configuration_for) : ?AbstractValueObject
    {
        return $this->configurations[$configuration_for];
    }
}