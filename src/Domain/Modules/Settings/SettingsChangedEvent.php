<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Settings;

use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use Fluxlabs\CQRS\Aggregate\AbstractValueObject;

/**
 * Class SettingsChangedEvent
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class SettingsChangedEvent extends Event
{
    private string $module;

    private ?AbstractValueObject $old;

    private AbstractValueObject $new;

    public function __construct(IEventUser $sender, string $module, ?AbstractValueObject $old, AbstractValueObject $new)
    {
        $this->module = $module;
        $this->old = $old;
        $this->new = $new;

        parent::__construct($sender);
    }

    public function getModule(): string
    {
        return $this->module;
    }

    public function getOld(): ?AbstractValueObject
    {
        return $this->old;
    }

    public function getNew(): AbstractValueObject
    {
        return $this->new;
    }
}