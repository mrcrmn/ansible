<?php

namespace Mrcrmn\Ansible;

use Symfony\Component\Yaml\Yaml;

/**
 * This class contains all methods needed to create a host inventory.yml file.
 * 
 * @see https://docs.ansible.com/ansible/latest/user_guide/intro_inventory.html
 */
class HostCollection
{
    /**
     * The string that defines the group, all hosts are assigned to.
     * 
     * @var string
     */
    public const ALL = 'all';

    /**
     * The string that defines the children of a host group.
     */
    public const CHILDREN = 'children';

    /**
     * The string that defines the key which introduces the array of given host names.
     */
    public const HOSTS = 'hosts';

    /**
     * The array which contains all the hosts.
     *
     * @var \Mrcrmn\Ansible\Host[]
     */
    protected $hosts = [];

    /**
     * Constructs a new instances and adds the given hosts to the collection.
     *
     * @param array $hosts
     */
    public function __construct(array $hosts = [])
    {
        foreach ($hosts as $host) {
            $this->addHost($host);
        }
    }

    /**
     * Returns all defined hosts.
     *
     * @return string[]
     */
    public function all()
    {
        return array_keys($this->hosts);
    }

    /**
     * Returns all host instances.
     *
     * @return Host[]
     */
    public function hosts()
    {
        return array_values($this->hosts);
    }

    /**
     * Checks if the given host name already exists on the collection.
     *
     * @param string $hostName
     * @return bool
     */
    public function exists(string $hostName)
    {
        return array_key_exists($hostName, $this->hosts);
    }

    /**
     * Adds the given host 
     *
     * @param string $host
     * @return $this
     */
    public function addHost(string $hostName)
    {
        if (! $this->exists($hostName)) {
            $this->hosts[$hostName] = new Host($hostName);
        }

        return $this;
    }

    /**
     * Gets a host instance if it exists or returns null.
     *
     * @param string $hostName
     * @return Host|null
     */
    public function get(string $hostName)
    {
        if (! $this->exists($hostName)) {
            return null;
        }

        return $this->hosts[$hostName];
    }

    /**
     * Gets all groups which are defined for the hosts.
     *
     * @return string[]
     */
    public function getDefinedGroups()
    {
        $groups = [];

        foreach ($this->hosts() as $host) {
            foreach ($host->groups() as $group) {
                $groups[] = $group; 
            }
        }

        return array_unique($groups);
    }

    /**
     * Returns the hosts which are assigned to the given group.
     *
     * @param string $group The name of the group.
     * @return Host[]
     */
    public function getHostsForGroup(string $group)
    {
        return array_filter($this->hosts(), function (Host $host) use ($group) {
            return $host->isAssignedTo($group);
        });
    }

    /**
     * Takes an array of Host instances and returns an array of host name strings.
     *
     * @param Host[] $hosts
     * @return string[]
     */
    protected function getHostNames(array $hosts)
    {
        return array_map(function (Host $host) {
            return $host->name();
        }, $hosts);
    }

    /**
     * Gets the host names for a given group.
     *
     * @param string $group
     * @return string[]
     */
    protected function getHostDefinitionFor(string $group)
    {
        // Wrap in array_values to reset keys.
        return array_values(
            $this->getHostNames(
                $this->getHostsForGroup($group)
            )
        );
    }

    /**
     * Return the array representation of the host file.
     *
     * @return array
     */
    public function toArray()
    {
        $children = [];

        foreach ($this->getDefinedGroups() as $group) {
            $children[$group] = [
                self::HOSTS => $this->getHostDefinitionFor($group)
            ];
        }

        return [
            self::ALL => [
                self::HOSTS => $this->all(),
                self::CHILDREN => $children
            ]
        ];
    }

    /**
     * Returns the yaml configuration file.
     *
     * @return string
     */
    public function toYaml()
    {
        return Yaml::dump($this->toArray(), 8, 2, Yaml::DUMP_OBJECT_AS_MAP);
    }
}