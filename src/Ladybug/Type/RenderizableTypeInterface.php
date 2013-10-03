<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

interface RenderizableTypeInterface extends TypeInterface
{

    /**
     * Gets template name
     * @return string
     */
    public function getTemplateName();

    public function getInlineValue();


}
