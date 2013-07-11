<?php

namespace Ladybug\Tests\Metadata;

use Ladybug\Metadata;

class SymfonyMetadataTest extends \PHPUnit_Framework_TestCase
{

    /** @var Metadata\SymfonyMetadata */
    protected $metadata;

    public function setUp()
    {
        $this->metadata = new Metadata\SymfonyMetadata();
    }

    public function testMetadataForValidValues()
    {
        $className = 'Symfony\HttpFoundation\Request';

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
