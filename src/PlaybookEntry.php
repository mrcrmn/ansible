<?php

namespace Mrcrmn\Ansible;

class PlaybookEntry
{
    protected $host;
    protected $tasks = [];

    public function __construct(string $host, array $tasks)
    {
        $this->host = $host;
        $this->tasks = $this->pushTasks($tasks);
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
}