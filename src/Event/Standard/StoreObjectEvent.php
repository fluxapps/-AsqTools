<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event\Standard;

use Fluxlabs\Assessment\Tools\Domain\Objects\IAsqObject;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;

/**
 * Class StoreObjectEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class StoreObjectEvent extends Event
{
    private IAsqObject $object;

    public function __construct(IEventUser $sender, IAsqObject $object)
    {
        $this->object = $object;

        parent::__construct($sender);
    }

    public function getObject() : IAsqObject
    {
        return $this->object;
    }
}