<?php

namespace Mrcrmn\Ansible\Tasks;

use InvalidArgumentException;
use Mrcrmn\Ansible\Task;

class Apt extends Task
{
    protected $taskName = 'apt';
    protected $package;
    protected $state;

    public const STATE_ABSENT = 'absent';
    public const STATE_BUILD_DEP = 'build-dep';
    public const STATE_LATEST = 'latest';
    public const STATE_PRESENT = 'present';
    public const STATE_FIXED = 'fixed';
    
    /**
     * 
     *
     * @param string|array $package The Package or Packages to install.
     */
    public function __construct(string $description, $package, string $state = 'present')
    {
        $this->description = $description;
        $this->package = $package;
        $this->setState($state);
    }

    public static function validStates(): array
    {
        return [
            static::STATE_ABSENT,
            static::STATE_BUILD_DEP,
            static::STATE_LATEST,
            static::STATE_PRESENT,
            static::STATE_FIXED,
        ];
    }

    public function setState(string $state)
    {
        if (! in_array($state, static::validStates())) {
            throw new InvalidArgumentException("'{$state}' is not a valid state for an apt package.");
        }

        $this->state = $state;
    }

    protected function getOptions(): array
    {
        return [
            'pkg' => $this->package,
            'state' => $this->state
        ];
    }
}