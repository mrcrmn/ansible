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
}