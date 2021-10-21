<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\DIC;

use ilLanguage;

/**
 * trait LanguageTrait
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
trait LanguageTrait
{
    protected ?ilLanguage $language;

    private function getLanguage() : ilLanguage
    {
        if ($this->language === null) {
            global $DIC;
            $this->language = $DIC->language();
        }

        return $this->language;
    }

    protected function getTranslation(string $key) : string
    {
        return $this->getLanguage()->txt($key);
    }
}