<?php

namespace DojoModule\Tools\Console\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console;

class Profile extends Console\Command\Command
{
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
        $this
        ->setName('profile')
        ->setDescription('Generate dojo build profile from module configs.')
        ->setHelp(<<<EOT
Generate dojo build profile from module configs.
EOT
        );
    }

    /**
     * @see Console\Command\Command
     */
    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $config = $this->getHelper('config')->getConfig();
        
        $buildConfig = $config['build'];
        $profile = array();
        $packages = array();
        
        foreach($buildConfig['packages'] as $name => $path){
            $packages[] = array(
                'name' => $name,
                'location' => $path
            );
        } 
        $profile = array(
            'basePath' => $buildConfig['basePath'],
            'releaseDir' => $buildConfig['releaseDir'],
            'action' => $buildConfig['action'],
            'cssOptimize' => $buildConfig['cssOptimize'],
            'layerOptimize' => $buildConfig['layerOptimize'],
            'stripConsole' => $buildConfig['stripConsole'],
            'selectorEngine' => $buildConfig['selectorEngine'],
            'packages' => $packages,
            'layers' => array(
                'dojo/dojo' => array(
                    'include' => $config['require'],
                    'custombase' => true,
                    'boot' => true
                )
            )            
        );
        $profile =Zend\Json::prettyPrint(json_encode($profile));
        $profile = "
            var profile = $profile

            if (typeof Packages !== 'undefined' && Packages.com.google.javascript.jscomp.Compiler) {
                Packages.com.google.javascript.jscomp.Compiler.setLoggingLevel(Packages.java.util.logging.Level.WARNING);
            } 
        ";        
        
        $output->write($profile . PHP_EOL);            
    }
}