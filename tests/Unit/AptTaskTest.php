<?php

namespace Mrcrmn\Ansible\Tests\Unit;

use InvalidArgumentException;
use Mrcrmn\Ansible\Tasks\Apt;
use Mrcrmn\Ansible\Tests\TestCase;

class AptTaskTest extends TestCase
{
    public function test_it_returns_the_excpected_array()
    {
        $task = new Apt('test', 'php7.4', Apt::STATE_PRESENT);

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
        $task = new Apt('test', ['php7.4', 'php7.4-common', 'php7.4-cli'], Apt::STATE_PRESENT);

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
        $this->expectException(InvalidArgumentException::class);

        $task = new Apt('test', 'php7.4', 'invalid_state');
    }
}