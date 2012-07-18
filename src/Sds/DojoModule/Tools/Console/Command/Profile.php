<?php

namespace DojoModule\Tools\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console;
use Zend\Json\Json;

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
        $requires = array();
        
        foreach($buildConfig['packages'] as $name => $path){
            $packages[] = array(
                'name' => $name,
                'location' => $path
            );
        } 
        
        foreach($config['require'] as $require){
            $requires[]  = $config['modules'][$require]['name'];
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
                    'include' => $requires,
                    'custombase' => true,
                    'boot' => true
                )
            )            
        );
        $profile =Json::prettyPrint(Json::encode($profile));
        $profile = "
            var profile = $profile

            if (typeof Packages !== 'undefined' && Packages.com.google.javascript.jscomp.Compiler) {
                Packages.com.google.javascript.jscomp.Compiler.setLoggingLevel(Packages.java.util.logging.Level.WARNING);
            } 
        ";        

        $output->write($profile . PHP_EOL);
        
        if (file_put_contents($buildConfig['profile'], $profile)){
            $output->write('Profile created at ' .$buildConfig['profile']);
        } else {
            $output->write('Profile creation failed at ' .$buildConfig['profile']);            
        }
    }
}