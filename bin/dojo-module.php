<?php

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfiguration;

ini_set('display_errors', true);
chdir(__DIR__);

$previousDir = '.';

while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());

    if ($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php": ' .
            'is DoctrineModule in a subdir of your application skeleton?'
        );
    }

    $previousDir = $dir;
    chdir($dir);
}

if (!(@include_once __DIR__ . '/../vendor/autoload.php') && !(@include_once __DIR__ . '/../../../autoload.php')) {
    throw new RuntimeException('Error: vendor/autoload.php could not be found. Did you run php composer.phar install?');
}

// get application stack configuration
$configuration = include 'config/application.config.php';

// setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfiguration(
    isset($configuration['service_manager']) ? $configuration['service_manager'] : array()
));
$serviceManager->setService('ApplicationConfiguration', $configuration);

/* @var $moduleManager \Zend\ModuleManager\ModuleManagerInterface */
$moduleManager = $serviceManager->get('ModuleManager');
$moduleManager->loadModules();

/* @var $application \Zend\Mvc\Application */
$application = $serviceManager->get('Application');
$application->bootstrap();

/* @var $cli \Symfony\Component\Console\Application */
$cli = $serviceManager->get('sds.dojo.cli');
$cli->run();