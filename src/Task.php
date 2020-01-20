<?php

namespace Mrcrmn\Ansible;

class Task
{
    protected $taskName;
    protected $description;
    protected $options = [];

    public function __construct(string $description, string $taskName, array $options)
    {
        $this->$description = $description;
        $this->$taskName = $taskName;
        $this->$options = $options;
    }

    protected function getOptions(): array
    {
        return $this->options;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->description,
            $this->taskName => $this->getOptions()
        ];
    }
}