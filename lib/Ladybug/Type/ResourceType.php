<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/ResourceType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;

class ResourceType extends BaseType
{

    const TYPE_ID = 'resource';

    protected $resourceType;
    protected $resourceCustomData;
    protected $isCustomData;

    public function __construct($var, $level, $container)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $container);

        $this->resourceType = get_resource_type($var);

        if ($this->resourceType == 'stream') {
            $stream_vars = stream_get_meta_data($var);

            // prevent unix sistems getting stream in files
            if (isset($stream_vars['stream_type']) && $stream_vars['stream_type'] == 'STDIO') $this->resourceType = 'file';

        }

        // is there a class to show the resource info?
        $include_class = $this->getIncludeClass($this->resourceType, 'resource');
        if (class_exists($include_class)) {
            $custom_dumper = new $include_class($var, $this->container);
            $this->resourceCustomData = FactoryType::factory(array(
                $custom_dumper->getData($var)
            ), $this->container);

            $this->isCustomData = true;

            unset($custom_dumper); $custom_dumper = NULL;
        }

    }

    public function export()
    {
        $value = array();

        if (!empty($this->resourceCustomData)) {

            if (is_array($this->resourceCustomData)) {
                foreach ($this->resourceCustomData as $k=>$v) {
                    if (is_array($v)) {
                        $value[$k] = array();
                        foreach ($v as $sub_k=>$sub_v) {
                            $stripped = strip_tags($sub_v);
                            if (strlen($stripped) > 0) $value[$k][$sub_k] = $stripped;
                        }

                    } else $value[$k] = strip_tags($v);
                }
            } else $value[] = $this->resourceCustomData;
        }

        return array(
            'type' => $this->type . '(' . $this->resourceType . ')',
            'value' => $value
        );
    }

    public function getViewParameters()
    {
        return array_merge(parent::getViewParameters(), array(
            'resource_custom_data' => $this->resourceCustomData,
            'resource_type' => $this->resourceType
        ));
    }

    public function setResourceCustomData($resourceCustomData)
    {
        $this->resourceCustomData = $resourceCustomData;
    }

    public function getResourceCustomData()
    {
        return $this->resourceCustomData;
    }

    public function setResourceType($resourceType)
    {
        $this->resourceType = $resourceType;
    }

    public function getResourceType()
    {
        return $this->resourceType;
    }

    public function setIsCustomData($isCustomData)
    {
        $this->isCustomData = $isCustomData;
    }

    public function getIsCustomData()
    {
        return $this->isCustomData;
    }


}
