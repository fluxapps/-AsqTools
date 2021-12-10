<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Settings;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\CommandDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\ModuleDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\TabDefinition;

/**
 * Class SettingsModuleDefinition
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class SettingsModuleDefinition extends ModuleDefinition
{
    public function __construct()
    {
        parent::__construct(
            ModuleDefinition::NO_CONFIG,
            [
                new CommandDefinition(
                    SettingsPage::CMD_SHOW_SETTINGS,
                    CommandDefinition::ACCESS_ADMIN,
                    SettingsPage::SETTINGS_TAB
                ),
                new CommandDefinition(
                    SettingsPage::CMD_STORE_SETTINGS,
                    CommandDefinition::ACCESS_ADMIN,
                    SettingsPage::SETTINGS_TAB
                )
            ],
            [],
            [
                new TabDefinition(
                    SettingsPage::SETTINGS_TAB,
                    'asqt_settings',
                    SettingsPage::CMD_SHOW_SETTINGS,
                    TabDefinition::PRIORITY_LOW
                )
            ]
        );
    }
}