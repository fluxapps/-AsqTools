<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Definition;

/**
 * Class CommandDefinition
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class CommandDefinition
{
    protected string $name;

    protected string $access_level;

    protected string $tab;

    public function __construct(string $name, string $access_level, string $tab)
    {
        $this->name = $name;
        $this->access_level = $access_level;
        $this->tab = $tab;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAccessLevel(): string
    {
        return $this->access_level;
    }

    public function getTab() : string
    {
        return $this->tab;
    }
}