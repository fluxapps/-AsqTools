<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules;

/**
 * Interface IAsqModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
interface IAccessModule extends IAsqModule
{
    /**
     * Returns true if User $user_id has right $right
     *
     * @param int $user_id
     * @param string $right
     * @return bool
     */
    public function hasAccess(int $user_id, string $right) : bool;
}