<?php

namespace Mrcrmn\Ansible\Modules\Packaging;

use Mrcrmn\Ansible\Task;

class AptRepository extends Task
{
    public const TASK_NAME = 'apt_repository';

    public function __construct(string $description, string $repo, string $state = 'present', $parameters = [])
    {
        parent::__construct($description, static::TASK_NAME, array_merge(
            [
                'repo' => $repo,
                'state' => $state,
            ],
            $parameters
        ));
    }

    protected function validParameters(): array
    {
        return [
            'repo' => 'string',
            'state' => ['absent', 'present'],
            'update_cache' => ['yes', 'no']
        ];
    }
}