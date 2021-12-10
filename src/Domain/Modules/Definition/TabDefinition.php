<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Definition;

/**
 * Class TabDefinition
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
class TabDefinition
{
    const PRIORITY_HIGH = 10;
    const PRIORITY_MEDIUM = 50;
    const PRIORITY_LOW = 90;

    protected string $id;

    protected string $text_key;

    protected string $link;

    protected int $priority;

    public function __construct(string $id, string $text_key, string $link, int $priority = self::PRIORITY_MEDIUM)
    {
        $this->id = $id;
        $this->text_key = $text_key;
        $this->link = $link;
        $this->priority = $priority;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getTextKey() : string
    {
        return $this->text_key;
    }

    public function getLink() : string
    {
        return $this->link;
    }

    public function getPriority() : int
    {
        return $this->priority;
    }
}