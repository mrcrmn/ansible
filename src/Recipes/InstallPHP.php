<?php

namespace Mrcrmn\Ansible\Recipes;

use Mrcrmn\Ansible\Modules\Packaging\Apt;
use Mrcrmn\Ansible\Modules\Packaging\AptRepository;

class InstallPHP extends Recipe
{
    /**
     * The default version to use.
     *
     * @var string
     */
    protected $version = '7.4';

    /**
     * The default lsit of extensions to install.
     *
     * @var array
     */
    protected $extensions = [
        'common',
        'cli',
        'fpm',
        'mbstring',
        'bcmath',
        'ctype',
        'tokenizer',
        'xml',
        'curl'
    ];

    /**
     * Create the Recipe.
     *
     * @param string $version The PHP version to install.
     * @param array $extensions The extensions to install. The given extensions will override the defaults.
     */
    public function __construct(string $version = '7.4', array $extensions = [])
    {
        $this->version = $version;

        if (! empty ($extensions)) {
            $this->extensions = $extensions;
        }
    }

    /**
     * Gets the list of tasks for this recipe.
     *
     * @return array
     */
    public function tasks(): array
    {
        return [
            new AptRepository('Add PHP Repository', 'ppa:andrej/php'),
            new Apt('Install PHP', 'php' . $this->version),
            new Apt('Install PHP Extensions', array_map(function ($ext) {
                return "php{$this->version}-{$ext}";
            }, $this->extensions))
        ];
    }
}