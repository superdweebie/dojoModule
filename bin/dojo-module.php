<?php

use Zend\Mvc\Application;

$applicationRoot = __DIR__ . '/../../../../';

chdir($applicationRoot);

require_once('vendor/autoload.php');

// get application stack configuration
$config = include 'config/application.config.php';

$application = Application::init($config);
$serviceManager = $application->getServiceManager();

/* @var $cli \Symfony\Component\Console\Application */
$cli = $serviceManager->get('sds.dojo.cli');
$cli->run();