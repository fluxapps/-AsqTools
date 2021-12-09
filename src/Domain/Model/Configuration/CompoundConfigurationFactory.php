<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Model\Configuration;

use Fluxlabs\CQRS\Aggregate\AbstractValueObject;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

/**
 * Abstract Class CompoundConfigurationFactory
 *
 * @package Fluxlabs\Assessment\Test
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
abstract class CompoundConfigurationFactory extends AbstractObjectFactory
{
    /**
     * @var AbstractObjectFactory[]
     */
    protected array $factories;

    protected function addFactory(AbstractObjectFactory $factory) {
        $this->factories[] = $factory;
    }

    /**
     * @param CompoundConfiguration|null $value
     * @return array
     */
    public function getFormfields(?AbstractValueObject $value): array
    {
        $fields = [];

        foreach ($this->factories as $factory) {
            $fields = array_merge(
                $fields,
                $factory->getFormfields(
                    $value ? $value->getConfiguration(get_class($factory)) : null
                )
            );
        }

        return $fields;
    }

    public function readObjectFromPost(array $postdata): AbstractValueObject
    {
        $object = new CompoundConfiguration();

        foreach ($this->factories as $factory) {
            $object->setConfiguration(
                get_class($factory),
                $factory->readObjectFromPost($postdata)
            );
        }

        return $object;
    }

    public function getDefaultValue(): AbstractValueObject
    {
        $object = new CompoundConfiguration();

        foreach ($this->factories as $factory) {
            $object->setConfiguration(
                get_class($factory),
                $factory->getDefaultValue()
            );
        }

        return $object;
    }
}