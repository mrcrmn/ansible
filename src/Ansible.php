<?php

namespace Mrcrmn\Ansible;

class Ansible
{
    /**
     * The host collection.
     *
     * @var \Mrcrmn\Ansible\HostCollection
     */
    protected $hosts;

    /**
     * Creates a new instance.
     *
     * @param string[] $hosts An array of strings representing the hostnames.
     */
    public function __construct(array $hosts = [])
    {
        $this->hosts = new HostCollection($hosts);
    }

    /**
     * Getter for the underlying host collection.
     *
     * @return \Mrcrmn\Ansible\HostCollection
     */
    public function hosts()
    {
        return $this->hosts;
    }
}