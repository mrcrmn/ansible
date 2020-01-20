<?php

namespace Mrcrmn\Ansible\Recipes;

use Mrcrmn\Ansible\Modules\Packaging\Apt;
use Mrcrmn\Ansible\Modules\Packaging\AptRepository;

class InstallBasics extends Recipe
{
    /**
     * Create the Recipe.
     */
    public function __construct()
    {}

    /**
     * Gets the list of tasks for this recipe.
     *
     * @return array
     */
    public function tasks(): array
    {
        return [
            new Apt('Install git', 'git'),
            new Apt('Install curl', 'curl'),
            new Apt('Install zip', 'zip'),
        ];
    }
}