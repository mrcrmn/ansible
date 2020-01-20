<?php

namespace Mrcrmn\Ansible\Modules\Packaging;

use InvalidArgumentException;
use Mrcrmn\Ansible\Task;

class Apt extends Task
{
    public const TASK_NAME = 'apt';
    
    /**
     * 
     *
     * @param string|array $package The Package or Packages to install.
     */
    public function __construct(string $description, $package, string $state = 'present', array $parameters = [])
    {
        parent::__construct($description, static::TASK_NAME, array_merge(
            [
                'pkg' => $package,
                'state' => $state
            ],
            $parameters
        ));
    }

    protected function validParameters(): array
    {
        return [
            'pkg' => 'string|array',
            'state' => ['absent', 'build_dep', 'latest', 'present', 'fixed'],
            'update_cache' => ['yes', 'no']
        ];
    }

}