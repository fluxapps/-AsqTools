<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Event\Standard;

use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use Fluxlabs\Assessment\Tools\UI\System\TabDefinition;

/**
 * Class AddTabEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
class AddTabEvent extends Event
{
    private TabDefinition $tab;

    public function __construct(IEventUser $sender, TabDefinition $tab)
    {
        $this->tab = $tab;

        parent::__construct($sender);
    }

    public function getTab() : TabDefinition
    {
        return $this->tab;
    }
}