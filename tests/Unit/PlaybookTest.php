<?php

namespace Mrcrmn\Ansible\Tests;

use Mrcrmn\Ansible\Playbook;
use Mrcrmn\Ansible\Recipes\InstallBasics;
use Mrcrmn\Ansible\Recipes\InstallNginx;
use Mrcrmn\Ansible\Recipes\InstallNode;
use Mrcrmn\Ansible\Recipes\InstallPHP;

class PlaybookTest extends TestCase
{
    public function test_basics()
    {
        $playbook = Playbook::fromRecipes([
            new InstallBasics,
            new InstallNginx,
            new InstallPHP('7.4'),
            new InstallNode('12')
        ]);

        $playbook->toYaml();

        file_put_contents(__DIR__ . '/../output/test.yml', $playbook->toYaml());
    }
}