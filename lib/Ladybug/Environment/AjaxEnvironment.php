<?php


namespace Ladybug\Environment;

use Ladybug\Container;
use Ladybug\Format;

class AjaxEnvironment extends BaseEnvironment
{

    public function getName()
    {
        return 'Ajax';
    }

    function getDefaultFormat()
    {
        return Format\TextFormat::FORMAT_NAME;
    }


    public function isActive()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * Returns true if the request is a XMLHttpRequest.
     *
     * It works if your JavaScript library set an X-Requested-With HTTP header.
     * It is known to work with Prototype, Mootools, jQuery.
     *
     * @return Boolean true if the request is an XMLHttpRequest, false otherwise
     */
    protected function isXmlHttpRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' == $_SERVER['HTTP_X_REQUESTED_WITH'];
    }
}
