<?php

namespace Mrcrmn\Ansible\Tests\Unit\Modules\Packaging;

use Mrcrmn\Ansible\Exceptions\InvalidParameterException;
use Mrcrmn\Ansible\Modules\Packaging\Apt;
use Mrcrmn\Ansible\Tests\TestCase;

class AptTaskTest extends TestCase
{
    public function test_it_returns_the_excpected_array()
    {
        $task = new Apt('test', 'php7.4', 'present');

        $this->assertEquals([
            'name' => 'test',
            'apt' => [
                'pkg' => 'php7.4',
                'state' => 'present'
            ]
        ], $task->toArray());
    }

    public function test_it_returns_the_excpected_array_when_given_an_array_of_packages()
    {
        $task = new Apt('test', ['php7.4', 'php7.4-common', 'php7.4-cli'], 'present');

        $this->assertEquals([
            'name' => 'test',
            'apt' => [
                'pkg' => ['php7.4', 'php7.4-common', 'php7.4-cli'],
                'state' => 'present'
            ]
        ], $task->toArray());
    }

    public function test_it_throws_an_error_when_given_an_invalid_state()
    {
        $this->expectException(InvalidParameterException::class);

        $task = new Apt('test', 'php7.4', 'invalid_state');
    }
}