<?php

namespace Mrcrmn\Ansible;

class Host
{
    /**
     * The hostname.
     * 
     * This might be an IP-Address or a domain.
     *
     * @var string
     */
    protected $name;

    /**
     * The groups this host is part of.
     *
     * @var string[]
     */
    protected $groups = [];

    /**
     * Constructs a new Host.
     *
     * @param string $name The hostname.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Gets all groups this host is assigned to.
     *
     * @return string[]
     */
    public function groups()
    {
        return $this->groups;
    }

    /**
     * Adds the host to the given group name.
     *
     * @param string $groupName
     * @return $this
     */
    public function addToGroup(string $groupName)
    {
        if (! in_array($groupName, $this->groups)) {
            $this->groups[] = $groupName;
        }

        return $this;
    }
}