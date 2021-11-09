<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\DIC;

use ILIAS\HTTP\Services;
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
    private ?Services $http = null;

    private function getHttp() : Services
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