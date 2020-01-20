<?php

namespace Mrcrmn\Ansible\Modules\Commands;

use Mrcrmn\Ansible\Task;

class Command extends Task
{
    public const TASK_NAME = 'command';

    /**
     * 
     *
     * @param string $command The command to execute.
     */
    public function __construct(string $description, string $command, array $parameters = [])
    {
        parent::__construct(
            $description,
            static::TASK_NAME,
            array_merge([
                'cmd' => $command,
            ], $parameters
        ));
    }

    protected function validParameters(): array
    {
        return [
            'cmd' => 'string'
        ];
    }
}