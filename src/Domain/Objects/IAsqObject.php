<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Objects;

/**
 * Interface IAsqObject
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IAsqObject
{
    public function getKey() : string;

    public function getConfiguration() : ObjectConfiguration;
}