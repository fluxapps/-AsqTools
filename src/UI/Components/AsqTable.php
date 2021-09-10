<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\UI\Components;

use Fluxlabs\Assessment\Tools\DIC\KitchenSinkTrait;
use ilTemplate;
use srag\asq\Infrastructure\Helpers\PathHelper;

/**
 * Class AsqTable
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class AsqTable
{
    use KitchenSinkTrait;
    use PathHelper;

    /**
     * @var String[]
     */
    private array $headers;

    /**
     * @var String[]
     */
    private array $data;

    /**
     * @var String[]
     */
    private array $actions;

    public function __construct(array $headers, array $data, array $actions =[])
    {
        $this->headers = $headers;
        $this->data = $data;
        $this->actions = $actions;
    }

    public function render() : string
    {
        $tpl = new ilTemplate($this->getBasePath(__DIR__) . 'templates/default/AsqTable.html', true, true);

        foreach ($this->headers as $header) {
            $tpl->setCurrentBlock('header');
            $tpl->setVariable('TITLE', $header);
            $tpl->parseCurrentBlock();
        }

        foreach ($this->data as $row) {
            foreach (array_keys($this->headers) as $key) {
                $tpl->setCurrentBlock('content_item');
                $tpl->setVariable('CONTENT', $row[$key]);
                $tpl->parseCurrentBlock();
            }

            $tpl->setCurrentBlock('content');
            $tpl->parseCurrentBlock();
        }

        if (count($this->actions) > 0) {
            $tpl->setCurrentBlock('foot');
            $tpl->setVariable('COLS', count($this->headers));
            $tpl->setVariable('ACTIONS', $this->renderActions());
            $tpl->parseCurrentBlock();
        }

        return $tpl->get();
    }

    private function renderActions() : string
    {
        $action_buttons = [];

        foreach ($this->actions as $title => $action) {
            $action_buttons[] = $this->getKSFactory()->button()->shy(
                $title,
                $action
            );
        }

        $actions = $this->getKSFactory()->dropdown()->standard($action_buttons)->withLabel('TODO Action');

        return $this->renderKSComponent($actions);
    }
}