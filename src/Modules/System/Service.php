<?php

namespace Mrcrmn\Ansible\Modules\System;

use Mrcrmn\Ansible\Task;

class Service extends Task
{
    public const TASK_NAME = 'service';
    
    /**
     * 
     *
     * @param string $service The name of the service.
     */
    public function __construct(string $description, $service, string $state = 'started', array $parameters = [])
    {
        parent::__construct($description, static::TASK_NAME, array_merge(
            [
                'name' => $service,
                'state' => $state
            ],
            $parameters
        ));
    }

    protected function validParameters(): array
    {
        return [
            'name' => 'string',
            'enabled' => ['yes', 'no'],
            'state' => ['reloaded', 'restarted', 'started', 'stopped']
        ];
    }

}