<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\Access;

use Fluxlabs\Assessment\Tools\DIC\LanguageTrait;
use Fluxlabs\Assessment\Tools\DIC\UserTrait;
use Fluxlabs\CQRS\Aggregate\AbstractValueObject;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

/**
 * Class DefaultAccessModule
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class AccessConfigurationFactory extends AbstractObjectFactory
{
    use UserTrait;

    const VAR_MEMBERS = 'ac_members';
    const VAR_STAFF = 'ac_staff';
    const VAR_ADMINS = 'ac_admins';

    /**
     * @param ?AccessConfiguration $value
     * @return array
     */
    public function getFormfields(?AbstractValueObject $value): array
    {
        $members = $this->factory->input()->field()->textarea($this->language->txt('asqt_label_members'));
        $staff = $this->factory->input()->field()->textarea($this->language->txt('asqt_label_staff'));
        $admins = $this->factory->input()->field()->textarea($this->language->txt('asqt_label_admins'));

        if ($value !== null) {
            $members = $members->withValue(implode(',', $value->getMembers()));
            $staff = $staff->withValue(implode(',', $value->getStaff()));
            $admins = $admins->withValue(implode(',', $value->getAdmins()));
        }

        return [
            self::VAR_MEMBERS => $members,
            self::VAR_STAFF => $staff,
            self::VAR_ADMINS => $admins
        ];
    }

    /**
     * @param array $postdata
     * @return AccessConfiguration
     */
    public function readObjectFromPost(array $postdata): AbstractValueObject
    {
        return AccessConfiguration::create(
            array_map('intval', explode(',', $postdata[self::VAR_MEMBERS])),
            array_map('intval', explode(',', $postdata[self::VAR_STAFF])),
            array_map('intval', explode(',', $postdata[self::VAR_ADMINS]))
        );
    }

    /**
     * @return AccessConfiguration
     */
    public function getDefaultValue(): AbstractValueObject
    {
        return AccessConfiguration::create([], [], [$this->getCurrentUser()]);
    }
}