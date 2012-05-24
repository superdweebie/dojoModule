<?php

namespace DojoModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DojoModule\View\Helper\Dojo;

class DojoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['dojo'];         
        $instance = new Dojo();         
        $instance->setTheme($config['theme']);
        $instance->setDojoRoot($config['dojoRoots'][$config['activeDojoRoot']]);
        $instance->setModules($config['modules']);
        $instance->setRequireModules($config['require']);
        $instance->setView($serviceLocator->get('Zend\View\Renderer\PhpRenderer'));
        return $instance;
    }
}