<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Access;

use Fluxlabs\CQRS\Aggregate\AbstractValueObject;

/**
 * Class DefaultAccessModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class AccessConfiguration extends AbstractValueObject
{
    const ACCESS_PUBLIC = 'public_access';
    const ACCESS_MEMBER = 'member_access';
    const ACCESS_STAFF = 'staff_access';
    const ACCESS_ADMIN = 'admin_access';

    /**
     * @var int[]
     */
    protected array $members;

    /**
     * @var int[]
     */
    protected array $staff;

    /**
     * @var int[]
     */
    protected array $admins;

    public static function create(array $members, array $staff, array $admins) : AccessConfiguration
    {
        $object = new AccessConfiguration();
        $object->members = $members;
        $object->staff = $staff;
        $object->admins = $admins;
        return $object;
    }

    /**
     * @return int[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * @return int[]
     */
    public function getStaff(): array
    {
        return $this->staff;
    }

    /**
     * @return int[]
     */
    public function getAdmins(): array
    {
        return $this->admins;
    }
}