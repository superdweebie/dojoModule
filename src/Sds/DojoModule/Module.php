<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DojoModule;

/**
 *
 * @since   1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
