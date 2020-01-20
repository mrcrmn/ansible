<?php

namespace Mrcrmn\Ansible\Tests\Unit\Modules\Packaging;

use Mrcrmn\Ansible\Exceptions\InvalidParameterException;
use Mrcrmn\Ansible\Modules\Packaging\AptRepository;
use Mrcrmn\Ansible\Tests\TestCase;

class AptRepositoryTaskTest extends TestCase
{
    public function test_it_returns_the_excpected_array()
    {
        $task = new AptRepository('test', 'ppa:andrej/php', 'present');

        $this->assertEquals([
            'name' => 'test',
            'apt_repository' => [
                'repo' => 'ppa:andrej/php',
                'state' => 'present'
            ]
        ], $task->toArray());
    }

    public function test_it_accepts_additional_parameters()
    {
        $task = new AptRepository('test', 'ppa:andrej/php', 'present', ['update_cache' => 'yes']);

        $this->assertEquals([
            'name' => 'test',
            'apt_repository' => [
                'repo' => 'ppa:andrej/php',
                'state' => 'present',
                'update_cache' => 'yes'
            ]
        ], $task->toArray());
    }

    public function test_it_throws_an_error_when_given_an_invalid_state()
    {
        $this->expectException(InvalidParameterException::class);

        $task = new AptRepository('test', 'ppa:andrej/php', 'invalid_state');
    }
}