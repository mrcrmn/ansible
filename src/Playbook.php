<?php

namespace Mrcrmn\Ansible;

use Mrcrmn\Ansible\Recipes\Recipe;
use Symfony\Component\Yaml\Yaml;

class Playbook
{
    protected $entries = [];

    public function __construct()
    {
        
    }

    public static function fromRecipes(array $recipes = [])
    {
        $static = new self;

        foreach ($recipes as $recipe) {
            $static->addRecipe($recipe);
        }

        return $static;
    }

    public function entry(string $host, array $tasks)
    {
        $this->addEntry(new PlaybookEntry($host, $tasks));
    }

    public function addEntry(PlaybookEntry $entry)
    {
        $this->entries[] = $entry;
    }

    public function addRecipe(Recipe $recipe)
    {
        $this->addEntry($recipe->getEntry());
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