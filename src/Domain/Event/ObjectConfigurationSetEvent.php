<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Event;

use ILIAS\Data\UUID\Uuid;
use DateTimeImmutable;
use Fluxlabs\CQRS\Aggregate\AbstractValueObject;
use Fluxlabs\CQRS\Event\AbstractDomainEvent;

/**
 * Class ObjectConfigurationSetEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ObjectConfigurationSetEvent extends AbstractDomainEvent
{
    const VAR_CONFIG = 'config';
    const VAR_CONFIG_FOR = 'config_for';

    protected ?AbstractValueObject $config;

    protected ?string $config_for;

    public function __construct(
        Uuid $aggregate_id,
        DateTimeImmutable $occured_on,
        AbstractValueObject $config = null,
        string $config_for = null
        ) {
            $this->config = $config;
            $this->config_for = $config_for;
            parent::__construct($aggregate_id, $occured_on);
    }

    public function getConfig() : ?AbstractValueObject
    {
        return $this->config;
    }

    public function getConfigFor() : ?string
    {
        return $this->config_for;
    }

    public function getEventBody() : string
    {
        $body = [];
        $body[self::VAR_CONFIG] = $this->config;
        $body[self::VAR_CONFIG_FOR] = $this->config_for;
        return json_encode($body);
    }

    protected function restoreEventBody(string $event_body) : void
    {
        $body = json_decode($event_body, true);
        $this->config = AbstractValueObject::createFromArray($body[self::VAR_CONFIG]);
        $this->config_for = $body[self::VAR_CONFIG_FOR];
    }

    public static function getEventVersion() : int
    {
        // initial version 1
        return 1;
    }
}
