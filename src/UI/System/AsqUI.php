<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\UI\System;

use Fluxlabs\Assessment\Tools\DIC\LanguageTrait;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\TabDefinition;
use Fluxlabs\Assessment\Tools\Event\Event;
use Fluxlabs\Assessment\Tools\Event\IEventUser;
use Fluxlabs\Assessment\Tools\Event\Standard\AddTabEvent;
use Fluxlabs\Assessment\Tools\Event\Standard\SetUIEvent;

/**
 * Class AsqUI
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
class AsqUI implements IAsqUI, IEventUser
{
    use LanguageTrait;

    private string $title = '';

    private string $description = '';

    private array $tabs = [];

    private string $active_tab = '';

    private string $content = '';

    private array $toolbar =[];

    function processEvent(Event $event): void
    {
        if (get_class($event) === SetUIEvent::class) {
            /** @var $data UIData */
            $data = $event->getData();

            if ($data->getContent() !== null) {
                $this->content = $data->getContent();
            }

            if ($data->getDescription() !== null) {
                $this->description = $data->getDescription();
            }

            if ($data->getTitle() !== null) {
                $this->title = $data->getTitle();
            }

            if ($data->getToolbar() !== null) {
                foreach ($data->getToolbar() as $tool) {
                    $this->toolbar[] = $tool;
                }
            }
        }
    }

    public function addTab(TabDefinition $definition) : void
    {
        $this->tabs[] = $definition;
    }

    public function setActiveTab(string $tab_key) : void
    {
        $this->active_tab = $tab_key;
    }

    public function getTabs(): array
    {
        return array_map(function(TabDefinition $tab) {
            return new UITab(
                $tab->getId(),
                $this->txt($tab->getTextKey()),
                $tab->getLink(),
                $tab->getId() === $this->active_tab
            );
        }, $this->tabs);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getToolbar(): array
    {
        return $this->toolbar;
    }
}