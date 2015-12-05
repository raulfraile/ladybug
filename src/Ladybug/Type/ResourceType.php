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

use Ladybug\Metadata\MetadataResolver;
use Ladybug\Metadata\MetadataInterface;
use Ladybug\Type\Exception\InvalidVariableTypeException;
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Inspector\InspectorManager;
use Ladybug\Model\VariableWrapper;

class ResourceType extends AbstractType
{

    const TYPE_ID = 'resource';

    /** @var string $resourceType */
    protected $resourceType;

    /** @var mixed $resourceCustomData */
    protected $resourceCustomData;

    /** @var FactoryType $factory */
    protected $factory;

    /** @var InspectorManager $inspectorManager */
    protected $inspectorManager;

    /** @var MetadataResolver $metadataResolver */
    protected $metadataResolver;

    protected $resourceId;

    /** @var string $icon */
    protected $icon;

    /** @var string $helpLink */
    protected $helpLink;

    /** @var string $version */
    protected $version;

    /** @var VariableWrapper $variableWrapper */
    protected $variableWrapper;

    public function __construct(FactoryType $factory, InspectorManager $inspectorManager, \Ladybug\Metadata\MetadataResolver $metadataResolver)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->factory = $factory;

        $this->metadataResolver = $metadataResolver;
        $this->inspectorManager = $inspectorManager;
    }

    public function load($var, $level = 1)
    {
        if (!$this->isResource($var)) {
            throw new InvalidVariableTypeException();
        }

        $this->level = $level;
        $this->resourceType = get_resource_type($var);
        $this->resourceId = (int) $var;

        if ($this->resourceType == 'stream') {
            $stream_vars = stream_get_meta_data($var);

            // prevent unix sistems getting stream in files
            if (isset($stream_vars['stream_type']) && $stream_vars['stream_type'] == 'STDIO') {
                $this->resourceType = 'file';
            }

        }

        $this->variableWrapper = new VariableWrapper($this->getResourceType(), $var, VariableWrapper::TYPE_RESOURCE);

        // metadata
        if ($this->metadataResolver->has($this->variableWrapper)) {
            $metadata = $this->metadataResolver->get($this->variableWrapper);

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

    public function getResourceCustomData()
    {
        return $this->resourceCustomData;
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
        $inspector = $this->inspectorManager->get($this->variableWrapper);
        if ($inspector instanceof InspectorInterface) {
            $inspector->setLevel($this->level + 1);
            $this->resourceCustomData = $inspector->get($this->variableWrapper);
        }

    }

    /**
     *
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @return string
     */
    public function getHelpLink()
    {
        return $this->helpLink;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    protected function isResource($var)
    {
        return !is_null(@get_resource_type($var));
    }

}
