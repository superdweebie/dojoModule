<?php
namespace DojoModule;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'DojoModule\View\Helper\Dojo' => 'DojoModule\Service\DojoFactory',
            )
        );
    }     
}
