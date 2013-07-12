<?php

namespace Ladybug\Tests\Metadata;

use Ladybug\Metadata;

class SilexMetadataTest extends \PHPUnit_Framework_TestCase
{

    /** @var Metadata\SilexMetadata */
    protected $metadata;

    public function setUp()
    {
        $this->metadata = new Metadata\SilexMetadata();
    }

    public function testMetadataForValidValues()
    {
        $className = 'Silex\Application';

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
