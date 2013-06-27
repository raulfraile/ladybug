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

use Ladybug\Extension\ExtensionInterface;
use Ladybug\Extension\Type\CollectionType;

class ResourceType extends BaseType
{

    const TYPE_ID = 'resource';

    /** @var string $resourceType */
    protected $resourceType;

    /** @var mixed $resourceCustomData */
    protected $resourceCustomData;

    /** @var FactoryType $factory */
    protected $factory;


    public function __construct(FactoryType $factory)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->factory = $factory;
    }

    public function load($var)
    {
        $this->resourceType = get_resource_type($var);

        if ($this->resourceType == 'stream') {
            $stream_vars = stream_get_meta_data($var);

            // prevent unix sistems getting stream in files
            if (isset($stream_vars['stream_type']) && $stream_vars['stream_type'] == 'STDIO') {
                $this->resourceType = 'file';
            }

        }

        // Resource data
        $this->loadData($var);
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

    public function getTemplateName()
    {
        return 'resource';
    }

    protected function loadData($var)
    {
        $includeClass = $this->getIncludeClass($this->resourceType, 'resource');
        if (class_exists($includeClass)) {

            /** @var $customDumper ExtensionInterface */
            $customDumper = new $includeClass($this->factory);
            $data = $customDumper->getData($var);

            $this->resourceCustomData = $data;
        }
    }

}
