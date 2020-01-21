<?php

namespace Mrcrmn\Ansible\Tests\Unit;

use Mrcrmn\Ansible\HostCollection;
use Mrcrmn\Ansible\Tests\TestCase;

class HostCollectionTest extends TestCase
{
    public function test_a_new_host_collection_can_be_constructed()
    {
        $coll = new HostCollection();

        $this->assertInstanceOf(HostCollection::class, $coll);
    }

    public function test_it_can_return_the_hosts()
    {
        $coll = new HostCollection([
            '127.0.0.1',
            '192.168.178.1'
        ]);

        // Check it ignores duplicates.
        $coll->addHost('127.0.0.1');

        $this->assertEquals([
            '127.0.0.1',
            '192.168.178.1'
        ], $coll->all());
        $this->assertCount(2, $coll->hosts());   
    }

    public function test_it_can_return_all_defined_groups()
    {
        $coll = new HostCollection([
            '127.0.0.1',
            '192.168.178.1'
        ]);

        $coll->get('127.0.0.1')
            ->addToGroup('webservers')
            ->addToGroup('prod');

        $coll->get('192.168.178.1')
            ->addToGroup('dbservers')
            ->addToGroup('prod');

        $this->assertEquals([
            'webservers',
            'prod',
            'dbservers'
        ], $coll->getDefinedGroups());
    }

    public function test_it_can_return_all_hosts_of_a_given_group()
    {
        $coll = new HostCollection([
            '127.0.0.1',
            '192.168.178.1'
        ]);

        $coll->get('127.0.0.1')
            ->addToGroup('webservers')
            ->addToGroup('prod');

        $coll->get('192.168.178.1')
            ->addToGroup('dbservers')
            ->addToGroup('prod');

        $this->assertEquals([
            $coll->get('127.0.0.1'),
            $coll->get('192.168.178.1'),
        ], $coll->getHostsForGroup('prod'));

        $this->assertEquals([
            $coll->get('127.0.0.1'),
            $coll->get('192.168.178.1'),
        ], $coll->getHostsForGroup('prod'));

        $this->assertEquals([
            $coll->get('127.0.0.1'),
        ], $coll->getHostsForGroup('webservers'));
    }

    public function test_the_array_gets_constructed_correctly()
    {
        $coll = new HostCollection([
            '127.0.0.1',
            '192.168.178.1'
        ]);

        $coll->get('127.0.0.1')
            ->addToGroup('webservers')
            ->addToGroup('prod');

        $coll->get('192.168.178.1')
            ->addToGroup('dbservers')
            ->addToGroup('prod');


        $this->assertEquals([
            'all' => [
                'hosts' => [
                    '127.0.0.1',
                    '192.168.178.1'
                ],
                'children' => [
                    'webservers' => [
                        'hosts' => [
                            '127.0.0.1'
                        ]
                    ],
                    'prod' => [
                        'hosts' => [
                            '127.0.0.1',
                            '192.168.178.1'
                        ]
                    ],
                    'dbservers' => [
                        'hosts' => [
                            '192.168.178.1'
                        ]
                    ]
                ]
            ]
        ], $coll->toArray());
    }

    public function test_the_yaml_file_gets_constructed_correctly()
    {
        $coll = new HostCollection([
            '127.0.0.1',
            '192.168.178.1'
        ]);

        $coll->get('127.0.0.1')
            ->addToGroup('webservers')
            ->addToGroup('prod');

        $coll->get('192.168.178.1')
            ->addToGroup('dbservers')
            ->addToGroup('prod');


        $this->assertEquals(
<<<EOT
all:
  hosts:
    - 127.0.0.1
    - 192.168.178.1
  children:
    webservers:
      hosts:
        - 127.0.0.1
    prod:
      hosts:
        - 127.0.0.1
        - 192.168.178.1
    dbservers:
      hosts:
        - 192.168.178.1

EOT
        , $coll->toYaml());
    }
}