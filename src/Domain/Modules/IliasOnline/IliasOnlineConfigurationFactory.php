<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Domain\Modules\IliasOnline;

use Fluxlabs\Assessment\Tools\DIC\LanguageTrait;
use Fluxlabs\CQRS\Aggregate\AbstractValueObject;
use srag\asq\UserInterface\Web\Form\Factory\AbstractObjectFactory;

/**
 * Class IliasOnlineConfigurationFactory
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class IliasOnlineConfigurationFactory extends AbstractObjectFactory
{
    const VAR_ONLINE = 'ioc_is_online';

    /**
     * @param IliasOnlineConfiguration|null $value
     * @return array
     */
    public function getFormfields(?AbstractValueObject $value): array
    {
        $online = $this->factory->input()->field()->checkbox($this->language->txt('asqt_label_online'));

        if ($value !== null) {
            $online = $online->withValue($value->isOnline());
        }

        return [
            self::VAR_ONLINE => $online
        ];
    }

    public function readObjectFromPost(array $postdata): AbstractValueObject
    {
        return IliasOnlineConfiguration::create($postdata[self::VAR_ONLINE]);
    }

    public function getDefaultValue(): AbstractValueObject
    {
        return IliasOnlineConfiguration::create(false);
    }
}