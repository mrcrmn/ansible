<?php

namespace Mrcrmn\Ansible\Recipes;

use Mrcrmn\Ansible\Modules\Commands\Command;
use Mrcrmn\Ansible\Modules\Packaging\Apt;
use Mrcrmn\Ansible\Modules\Packaging\AptRepository;
use Mrcrmn\Ansible\Modules\System\Service;

class InstallNode extends Recipe
{
    protected $version = '12';

    /**
     * Create the Recipe.
     */
    public function __construct(string $version = '12')
    {
        $this->version = $version;
    }

    /**
     * Gets the list of tasks for this recipe.
     *
     * @return array
     */
    public function tasks(): array
    {
        return [
            new Command('Load Nodesource', "curl -sL https://deb.nodesource.com/setup_{$this->version}.x | sudo -E bash -"),
            new Apt('Install Node.js', 'nodejs', 'present', ['update_cache' => 'yes']),
        ];
    }
}