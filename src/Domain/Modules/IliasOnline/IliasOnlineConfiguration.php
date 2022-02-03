<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\IliasOnline;

use Fluxlabs\CQRS\Aggregate\AbstractValueObject;

/**
 * Class IliasOnlineConfiguration
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class IliasOnlineConfiguration extends AbstractValueObject
{
    protected bool $is_online;

    public static function create(bool $is_online) : IliasOnlineConfiguration
    {
        $object = new IliasOnlineConfiguration();
        $object->is_online = $is_online;
        return $object;
    }

    public function isOnline() : bool
    {
        return $this->is_online;
    }
}