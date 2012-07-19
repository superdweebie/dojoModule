<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DojoModule\Tools\Console\Command;

use Sds\DojoModule\Tools\ProfileGenerator;
use Symfony\Component\Console;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class GenerateProfile extends Console\Command\Command
{
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
        $this
        ->setName('generate:profile')
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

        list($profile, $path) = ProfileGenerator::generate($config);

        $output->write($profile . PHP_EOL);

        if (isset($profile)){
            $output->write('Profile created at ' .$path);
        } else {
            $output->write('Profile creation failed at ' .$path);
        }
    }
}