<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Event;

use ILIAS\Data\UUID\Uuid;
use ilDateTime;
use Fluxlabs\CQRS\Event\AbstractDomainEvent;

/**
 * Class ObjectConfigurationRemovedEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class ObjectConfigurationRemovedEvent extends AbstractDomainEvent
{
    protected ?string $config_for;

    public function __construct(
        Uuid $aggregate_id,
        ilDateTime $occured_on,
        string $config_for = null
        ) {
            $this->config_for = $config_for;
            parent::__construct($aggregate_id, $occured_on);
    }

    public function getConfigFor() : ?string
    {
        return $this->config_for;
    }

    public function getEventBody() : string
    {
        return $this->config_for;
    }

    protected function restoreEventBody(string $event_body) : void
    {
        $this->config_for = $event_body;
    }

    public static function getEventVersion() : int
    {
        // initial version 1
        return 1;
    }
}
