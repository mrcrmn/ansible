<?php

namespace Mrcrmn\Ansible\Tests\Unit;

use Mrcrmn\Ansible\HostCollection;
use Mrcrmn\Ansible\Tests\TestCase;

class HostCollectionTest extends TestCase
{
    public function test_a_new_host_collection_can_be_constructed()
    {
        $coll = new HostCollection([
            '127.0.0.1',
            '192.168.178.1'
        ]);

        $this->assertInstanceOf(HostCollection::class, $coll);
        $this->assertEquals([
            '127.0.0.1',
            '192.168.178.1'
        ], $coll->all());
        $this->assertCount(2, $coll->hosts());
    }
}