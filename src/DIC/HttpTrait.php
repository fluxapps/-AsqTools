<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\DIC;

use ILIAS\DI\HTTPServices;
use Psr\Http\Message\ServerRequestInterface;

/**
 * trait HttpTrait
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG <adi@fluxlabs.ch>
 */
trait HttpTrait
{
    private ?HTTPServices $http = null;

    private function getHttp() : HTTPServices
    {
        if ($this->http === null) {
            global $DIC;
            $this->http = $DIC->http();
        }

        return $this->http;
    }

    protected function getRequest() : ServerRequestInterface
    {
        return $this->getHttp()->request();
    }
}