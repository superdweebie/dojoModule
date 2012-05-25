<?php

namespace DojoModule\Service;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CliFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['dojo'];
        $configHelper  = new \DojoModule\Tools\Console\Helper\ConfigHelper($config);
        $helperSet     = new HelperSet;
        $helperSet->set($configHelper, 'config');
        
        $cli = new Application;
        $cli->setName('DojoModule Command Line Interface');
        $cli->setVersion('dev-master');
        $cli->setHelperSet($helperSet);
        
        $cli->addCommands(array(           
            new \DojoModule\Tools\Console\Command\Profile(),        
        ));

        return $cli;
    }
}
