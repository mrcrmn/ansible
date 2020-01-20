<?php

namespace Mrcrmn\Ansible\Recipes;

use Mrcrmn\Ansible\Task;
use Mrcrmn\Ansible\PlaybookEntry;

abstract class Recipe
{
    /**
     * Get the tasks for the recipe
     *
     * @return Task[]
     */
    public abstract function tasks(): array;

    /**
     * Converts the recipe to a PlaybookEntry.
     *
     * @return PlaybookEntry
     */
    public function getEntry(): PlaybookEntry
    {
        return new PlaybookEntry('all', $this->tasks());
    }
}