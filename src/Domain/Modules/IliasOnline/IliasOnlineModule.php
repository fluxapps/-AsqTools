<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\IliasOnline;

use Fluxlabs\Assessment\Tools\Domain\Modules\AbstractAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\ModuleDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\IModuleDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\Settings\SettingsChangedEvent;

/**
 * Class IliasOnlineModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class IliasOnlineModule extends AbstractAsqModule
{
    public function processEvent(object $event): void
    {
        if (get_class($event) === SettingsChangedEvent::class) {
            if ($event->getModule() === self::class) {
                $this->processOnlineState($event->getNew());
            }
        }
    }

    private function processOnlineState(IliasOnlineConfiguration $new) {
        $settings = $this->access->getReference()->getSettings();
        $settings->setOnline($new->isOnline());
        $settings->save();
    }

    public function getModuleDefinition(): IModuleDefinition
    {
        return new ModuleDefinition(IliasOnlineConfigurationFactory::class);
    }
}