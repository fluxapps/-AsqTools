<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\DIC;

use ILIAS\DI\UIServices;
use ILIAS\UI\Factory;
use ILIAS\UI\Component\Component;

/**
 * trait KitchenSinkTrait
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
trait KitchenSinkTrait
{
    private ?UIServices $ui = null;

    private function getUI() : UIServices
    {
        if ($this->ui === null) {
            global $DIC;
            $this->ui = $DIC->ui();
        }

        return $this->ui;
    }

    protected function getKSFactory() : Factory
    {
        return $this->getUI()->factory();
    }

    protected function renderKSComponent(Component $component) : string
    {
        return $this->getUI()->renderer()->render($component);
    }
}