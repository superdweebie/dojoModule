<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DoctrineExtensionsModule\Service;

use Sds\DoctrineExtensionsModule\Controller\RestfulController;
use Sds\DoctrineExtensionsModule\Serializer\Serializer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class RestfulControllerFactory implements FactoryInterface
{

    protected $configKey;

    public function __construct($configKey){
        $this->configKey = $configKey;
    }

    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')[$this->configKey];

        $controller = new RestfulController();
        $controller->setDocumentClass($config['documentClass']);
        $controller->setDocumentManager($serviceLocator->get(
            'doctrine.documentmanager.'.$config['documentManager']
        ));
        $controller->setSerializer($serviceLocator->get($config['serializer']));
        $controller->setValidator($serviceLocator->get($config['validator']));

        return $controller;
    }
}
