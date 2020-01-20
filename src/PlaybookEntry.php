<?php

namespace Mrcrmn\Ansible;

class PlaybookEntry
{
    protected $host = 'all';
    protected $tasks = [];

    public function __construct(string $host = 'all', array $tasks = [])
    {
        $this->host = $host;
        $this->pushTasks($tasks);
    }

    public function pushTasks(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->pushTask($task);
        } 
    }

    public function pushTask(Task $task): void
    {
        $this->tasks[] = $task;
    }

    public function toArray(): array
    {
        return [
            'hosts' => $this->host, 
            'tasks' => array_map(function (Task $task) {
                return $task->toArray();
            }, $this->tasks)
        ];
    }
}