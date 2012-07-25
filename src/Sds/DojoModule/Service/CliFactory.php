<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DojoModule\Service;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory to create the CLI app used to generate a dojo build profile
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class CliFactory implements FactoryInterface
{
    /**
     * Sets the dojo theme to use.
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Symfony\Component\Console\Application
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['sds']['dojo'];
        $configHelper  = new \Sds\DojoModule\Tools\Console\Helper\ConfigHelper($config);
        $helperSet     = new HelperSet;
        $helperSet->set($configHelper, 'config');

        $cli = new Application;
        $cli->setName('DojoModule Command Line Interface');
        $cli->setHelperSet($helperSet);

        $cli->addCommands(array(
            new \Sds\DojoModule\Tools\Console\Command\GenerateProfile(),
        ));

        return $cli;
    }
}
