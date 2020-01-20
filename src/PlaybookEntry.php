<?php

namespace Mrcrmn\Ansible;

class PlaybookEntry
{
    protected string $host;
    protected array $tasks = [];

    public function __construct(string $description, string $host, array $tasks)
    {
        $this->$description = $description;
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