<?php

/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/FactoryType: Types factory
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector;

use Ladybug\Inspector\InspectorInterface;

class InspectorManager
{

    protected $inspectors;

    public function __construct()
    {

    }

    public function add(InspectorInterface $inspector)
    {
        $this->inspectors[] = $inspector;
    }

    public function get(InspectorDataWrapper $data)
    {
        foreach ($this->inspectors as $inspector) {
            /** @var InspectorInterface $inspector */

            if ($inspector->accept($data)) {
                return $inspector;
            }
        }

        return null;
    }

}
