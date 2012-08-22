<?php
return array(
    'modules' => array(
        'Sds\DojoModule'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'vendor/superdweebie/dojo-module/tests/test.module.config.php',            
        ),
        'module_paths' => array(
            './vendor',
        ),
    ),
);
