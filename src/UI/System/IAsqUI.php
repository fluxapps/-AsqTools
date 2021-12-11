<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\UI\System;

use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\TabDefinition;

/**
 * Interface IAsqUI
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
interface IAsqUI
{
    /**
     * The tabs to display
     *
     * @return UITab[]
     */
    public function getTabs() : array;

    /**
     * The title to display
     *
     * @return string
     */
    public function getTitle() : string;

    /**
     * The description to display
     *
     * @return string
     */
    public function getDescription() : string;

    /**
     * The content to display
     *
     * @return string
     */
    public function getContent() : string;

    /**
     * The Toolbar items to display
     *
     * @return array
     */
    public function getToolbar() : array;
}