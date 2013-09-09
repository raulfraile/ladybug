<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Environment;

use Ladybug\Format;

class BrowserEnvironment extends AbstractEnvironment
{

    public function getName()
    {
        return 'Browser';
    }

    public function supports()
    {
        return true;
    }

    public function getDefaultFormat()
    {
        return Format\HtmlFormat::FORMAT_NAME;
    }
}
