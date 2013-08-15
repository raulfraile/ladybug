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
use Ladybug\Metadata\MetadataInterface;
use Ladybug\Type\Exception\InvalidVariableTypeException;

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

    protected $resourceId;

    /** @var string $icon */
    protected $icon;

    /** @var string $helpLink */
    protected $helpLink;

    /** @var string $version */
    protected $version;

    public function __construct(FactoryType $factory, \Ladybug\Inspector\InspectorFactory $inspectorFactory, \Ladybug\Metadata\MetadataResolver $metadataResolver)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->factory = $factory;

        $this->metadataResolver = $metadataResolver;
        $this->inspectorFactory = $inspectorFactory;
    }

    public function load($var, $level = 1)
    {
        if (!is_resource($var)) {
            throw new InvalidVariableTypeException();
        }

        $this->level = $level;
        $this->resourceType = get_resource_type($var);
        $this->resourceId = (int)$var;

        if ($this->resourceType == 'stream') {
            $stream_vars = stream_get_meta_data($var);

            // prevent unix sistems getting stream in files
            if (isset($stream_vars['stream_type']) && $stream_vars['stream_type'] == 'STDIO') {
                $this->resourceType = 'file';
            }

        }

        // metadata
        if ($this->metadataResolver->has($this->resourceType, MetadataInterface::TYPE_RESOURCE)) {
            $metadata = $this->metadataResolver->getMetadata($this->resourceType, MetadataInterface::TYPE_RESOURCE);

            if (array_key_exists('help_link', $metadata)) {
                $this->helpLink = $metadata['help_link'];
            }

            if (array_key_exists('icon', $metadata)) {
                $this->icon = $metadata['icon'];
            }

            if (array_key_exists('version', $metadata)) {
                $this->version = $metadata['version'];
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

    public function getResourceId()
    {
        return $this->resourceId;
    }

    public function isComposed()
    {
        return true;
    }

    /**
     * @param string $helpLink
     */
    public function setHelpLink($helpLink)
    {
        $this->helpLink = $helpLink;
    }

    /**
     * @return string
     */
    public function getHelpLink()
    {
        return $this->helpLink;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }


}
