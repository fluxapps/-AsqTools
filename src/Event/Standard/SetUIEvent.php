<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event\Standard;

use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use Fluxlabs\Assessment\Tools\UI\System\UIData;

/**
 * Class SetUIEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
class SetUIEvent extends Event
{
    private UIData $data;

    public function __construct(IEventUser $sender, UIData $data)
    {
        $this->data = $data;

        parent::__construct($sender);
    }

    public function getData() : UIData
    {
        return $this->data;
    }
}