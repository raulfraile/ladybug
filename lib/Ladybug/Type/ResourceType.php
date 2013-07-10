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

use Ladybug\Inspector\InspectorFactory;
use Ladybug\Metadata\MetadataResolver;

class ResourceType extends AbstractType
{

    const TYPE_ID = 'resource';

    /** @var string $resourceType */
    protected $resourceType;

    /** @var mixed $resourceCustomData */
    protected $resourceCustomData;

    /** @var FactoryType $factory */
    protected $factory;

    /** @var InspectorFactory $inspectorFactory */
    protected $inspectorFactory;

    /** @var MetadataResolver $metadataResolver */
    protected $metadataResolver;

    public function __construct(FactoryType $factory, \Ladybug\Inspector\InspectorFactory $inspectorFactory, \Ladybug\Metadata\MetadataResolver $metadataResolver)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->factory = $factory;

        $this->metadataResolver = $metadataResolver;
        $this->inspectorFactory = $inspectorFactory;
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

        // is there a class to show the object data?
        $service = 'inspector_resource_'.str_replace(array('\\', ' '), '_', strtolower($this->resourceType));

        if ($this->inspectorFactory->has($service)) {
            $inspector = $this->inspectorFactory->factory($service);
            $inspector->setLevel($this->level + 1);
            $this->resourceCustomData = $inspector->getData($var);
        }

    }

}
