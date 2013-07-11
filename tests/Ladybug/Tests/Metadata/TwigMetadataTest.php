<?php

namespace Ladybug\Tests\Metadata;

use Ladybug\Metadata;

class TwigMetadataTest extends \PHPUnit_Framework_TestCase
{

    /** @var Metadata\TwigMetadata */
    protected $metadata;

    public function setUp()
    {
        $this->metadata = new Metadata\TwigMetadata();
    }

    public function testMetadataForValidValues()
    {
        $className = 'Twig_Environment';

        $this->assertTrue($this->metadata->hasMetadata($className));

        $metadata = $this->metadata->getMetadata($className);
        $this->assertArrayHasKey('help_link', $metadata);
        $this->assertArrayHasKey('icon', $metadata);
    }

    public function testMetadataForInvalidValues()
    {
        $className = 'Test\Test';

        $this->assertFalse($this->metadata->hasMetadata($className));

        $metadata = $this->metadata->getMetadata($className);
        $this->assertEmpty($metadata);
    }

}
