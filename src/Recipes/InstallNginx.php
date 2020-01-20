<?php

namespace Mrcrmn\Ansible\Recipes;

use Mrcrmn\Ansible\Modules\Packaging\Apt;
use Mrcrmn\Ansible\Modules\Packaging\AptRepository;
use Mrcrmn\Ansible\Modules\System\Service;

class InstallNginx extends Recipe
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
            new Apt('Install Nginx', 'nginx'),
            new Service('Ensure Nginx is running', 'nginx', 'started', ['enabled' => 'yes'])
        ];
    }
}