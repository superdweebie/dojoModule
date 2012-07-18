<?php

namespace DojoModule\Tools\Console\Helper;

use Symfony\Component\Console\Helper\Helper;

class ConfigHelper extends Helper
{
    protected $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    public function getConfig()
    {
        return $this->config;
    }
    public function getName()
    {
        return 'config';
    }
}