<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DojoModule\Tools;

use Zend\Json\Json;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ProfileGenerator
{
    public static function generate(array $config, $profilePath = null)
    {
        $buildConfig = $config['build'];
        $packages = array();

        foreach($buildConfig['packages'] as $name => $path){
            $packages[] = array(
                'name' => $name,
                'location' => $path
            );
        }

        $profile = $buildConfig;
        unset($profile['profilePath']);
        $profile['packages'] = $packages;
        
        $profile =Json::prettyPrint(Json::encode($profile));
        $profile = str_replace('<profile>', $profile, file_get_contents(__DIR__ . '/Profile.js.template'));

        if (!isset($profilePath)) {
            $profilePath = $buildConfig['profilePath'];
        }

        if (file_put_contents($profilePath, $profile)){
            return array($profile, $profilePath);
        } else {
            return array(null, $profilePath);
        }
    }
}