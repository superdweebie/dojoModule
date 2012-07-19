<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DojoModule\Tools\Console\Helper;

use Symfony\Component\Console\Helper\Helper;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConfigHelper extends Helper
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
    public function getConfig()
    {
        return $this->config;
    }
    public function getName()
    {
        return 'config';
    }
}