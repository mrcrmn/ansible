<?php

namespace Mrcrmn\Ansible;

class Ansible
{
    protected $hosts;

    public function __construct(array $hosts = [])
    {
        $this->hosts = new HostCollection($hosts);
    }
}