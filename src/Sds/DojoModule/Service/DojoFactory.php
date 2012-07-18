<?php
/**
 * @package    DojoModule
 * @license    MIT
 */
namespace DojoModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DojoModule\View\Helper\Dojo;

/**
 * Factory to Dojo view helper
 * 
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DojoFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \DojoModule\View\Helper\Dojo
     */       
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