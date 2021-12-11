<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\UI\System;

/**
 * Class UITab
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
class UITab
{
    protected string $id;

    protected string $text;

    protected string $link;

    protected bool $active;

    public function __construct(string $id, string $text, string $link, bool $active)
    {
        $this->id = $id;
        $this->text = $text;
        $this->link = $link;
        $this->active = $active;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function getLink() : string
    {
        return $this->link;
    }

    public function isActive() : bool
    {
        return $this->active;
    }
}