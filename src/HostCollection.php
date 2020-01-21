<?php

namespace Mrcrmn\Ansible;

class HostCollection
{
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
     * @return void
     */
    public function hosts()
    {
        return $this->hosts;
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
}