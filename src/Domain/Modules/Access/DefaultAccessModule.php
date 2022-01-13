<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Access;

use Fluxlabs\Assessment\Tools\Domain\Modules\AbstractAsqModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\Definition\ModuleDefinition;
use Fluxlabs\Assessment\Tools\Domain\Modules\IAccessModule;
use Fluxlabs\Assessment\Tools\Domain\Modules\IModuleDefinition;
use srag\asq\Application\Exception\AsqException;

/**
 * Class DefaultAccessModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class DefaultAccessModule extends AbstractAsqModule implements IAccessModule
{
    public function hasAccess(int $user_id, string $right): bool
    {
         switch ($right) {
             case AccessConfiguration::ACCESS_STAFF:
                 return $this->isStaff($user_id);
             case AccessConfiguration::ACCESS_ADMIN:
                 return $this->isAdmin($user_id);
             case AccessConfiguration::ACCESS_MEMBER:
                 return $this->isMember($user_id);
             case AccessConfiguration::ACCESS_PUBLIC:
                 return true;
             default:
                 throw new AsqException('Unknown access level: ' . $right);
         }
    }

    public function isMember(int $user_id) : bool
    {
        return in_array($user_id, $this->getModuleConfiguration()->getMembers()) || $this->isAdmin($user_id);
    }

    public function isStaff(int $user_id) : bool
    {
        return in_array($user_id, $this->getModuleConfiguration()->getStaff()) || $this->isAdmin($user_id);
    }

    public function isAdmin(int $user_id) : bool
    {
        return in_array($user_id, $this->getModuleConfiguration()->getAdmins());
    }

    public function getModuleDefinition(): IModuleDefinition
    {
        return new ModuleDefinition(AccessConfigurationFactory::class);
    }
}