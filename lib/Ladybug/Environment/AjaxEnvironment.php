<?php

namespace Ladybug\Environment;

use Ladybug\Format;

class AjaxEnvironment extends BaseEnvironment
{

    protected $httpXRequestedWith = null;

    public function __construct($httpXRequestedWith = null)
    {
        if (!is_null($httpXRequestedWith)) {
            $this->httpXRequestedWith = $httpXRequestedWith;
        } elseif (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)) {
            $this->httpXRequestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'];
        }
    }

    public function getName()
    {
        return 'Ajax';
    }

    public function getDefaultFormat()
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
        return !is_null($this->httpXRequestedWith) && 'XMLHttpRequest' == $this->httpXRequestedWith;
    }
}
