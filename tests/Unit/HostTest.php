<?php

namespace Mrcrmn\Ansible\Tests\Unit;

use Mrcrmn\Ansible\Host;
use Mrcrmn\Ansible\Tests\TestCase;

class HostTest extends TestCase
{
    public function test_a_new_host_can_be_constructed()
    {
        $host = new Host('127.0.0.1');

        $this->assertInstanceOf(Host::class, $host);
    }

    public function test_a_host_can_be_added_to_a_group()
    {
        $host = new Host('127.0.0.1');
        
        $host->addToGroup('webservers');
        $host->addToGroup('prod');

        $this->assertCount(2, $host->groups());

        // Duplicate. We expect it to still be only 2.
        $host->addToGroup('prod');
        $this->assertCount(2, $host->groups());
    }

    public function test_it_can_return_its_name()
    {
        $host = new Host('127.0.0.1');

        $this->assertEquals('127.0.0.1', $host->name());
    }

    public function test_it_knows_which_group_its_assigned_to()
    {
        $host = new Host('127.0.0.1');
        
        $host->addToGroup('webservers');
        $host->addToGroup('prod');

        $this->assertTrue($host->isAssignedTo('webservers'));
        $this->assertTrue($host->isAssignedTo('prod'));
        $this->assertFalse($host->isAssignedTo('dbservers'));
    }
}