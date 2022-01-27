<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\DIC;

use ilLanguage;
use ilObjUser;

/**
 * trait UserTrait
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
trait UserTrait
{
    protected ?ilObjUser $user = null;

    private function getUser() : ilObjUser
    {
        if ($this->user === null) {
            global $DIC;
            $this->user = $DIC->user();
        }

        return $this->user;
    }

    protected function getCurrentUser() : int
    {
        return $this->getUser()->getId();
    }

    protected function getUsername(int $user_id) : string
    {
        $user = new ilObjUser($user_id);
        return $user->getPublicName();
    }
}