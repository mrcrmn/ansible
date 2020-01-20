<?php

namespace Mrcrmn\Ansible;

use Symfony\Component\Yaml\Yaml;

class Playbook
{
    protected $entries = [];

    public function entry(string $host, array $tasks)
    {
        $this->entries[] = new PlaybookEntry($host, $tasks);
    }

    public function toArray(): array
    {
        return array_map(function(PlaybookEntry $entry) {
            return $entry->toArray();
        }, $this->entries);
    }

    public function toYaml(): string
    {
        return Yaml::dump($this->toArray(), 8, 2, Yaml::DUMP_OBJECT_AS_MAP);
    }
}