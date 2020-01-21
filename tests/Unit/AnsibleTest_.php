<?php

namespace Mrcrmn\Ansible\Tests\Unit;

use Mrcrmn\Ansible\Ansible;
use Mrcrmn\Ansible\Tests\TestCase;

class AnsibleTest extends TestCase
{
    public function test_it_can_take_a_list_of_hosts()
    {
        $ans = new Ansible([
            '127.0.0.1'
        ]);
    }
}