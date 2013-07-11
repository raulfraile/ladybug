<?php

namespace Ladybug\Tests\Metadata;

use Ladybug\Metadata;

class PhpObjectsMetadataTest extends \PHPUnit_Framework_TestCase
{

    /** @var Metadata\PhpObjectsMetadata */
    protected $metadata;

    public function setUp()
    {
        $this->metadata = new Metadata\PhpObjectsMetadata();
    }

    public function testMetadataForValidValues()
    {
        $className = 'DateTime';

        $this->assertTrue($this->metadata->hasMetadata($className));

        $metadata = $this->metadata->getMetadata($className);
        $this->assertArrayHasKey('help_link', $metadata);
        $this->assertArrayHasKey('icon', $metadata);
        $this->assertArrayHasKey('version', $metadata);
    }

    public function testMetadataForInvalidValues()
    {
        $className = 'Test\Test';

        $this->assertFalse($this->metadata->hasMetadata($className));

        $metadata = $this->metadata->getMetadata($className);
        $this->assertEmpty($metadata);
    }

}
