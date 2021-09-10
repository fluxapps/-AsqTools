<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\DIC;

use ilCtrl;

/**
 * trait CtrlTrait
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
trait CtrlTrait
{
    private ?ilCtrl $ctrl = null;

    private function getCtrl() : ilCtrl
    {
        if ($this->ctrl === null) {
            global $DIC;
            $this->ctrl = $DIC->ctrl();
        }

        return $this->ctrl;
    }

    public function getCommandLink(string $command) : string
    {
        return $this->getCtrl()->getLinkTargetByClass(
            end($this->getCtrl()->getCallHistory())['class'],
            $command
        );
    }

    public function redirectToCommand(string $command) : void
    {
        $link = $this->getCommandLink($command);
        $this->getCtrl()->redirectToURL($link);
    }

    public function setLinkParameter(string $parameter, string $value) : void
    {
        $this->getCtrl()->setParameterByClass(
            $this->getCtrl()->getCmdClass(),
            $parameter,
            $value);
    }
}