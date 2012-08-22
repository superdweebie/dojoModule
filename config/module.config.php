<?php
return array(
    'sds' => array(
        'dojo' => array(
            'activeDojoRoot' => 'release',
            'dojoRoots' => array(
                'source' => 'js/dojo_src',
                'release' => 'js/dojo_rel'
            ),
            'theme' => 'claro',

            //An layer to load. If null, will default to baseless dojo
            'layer' => null,

            //An array of modules to require. Each module may also define an array
            //of target layer names. This is used by the build profile generator
            //to specify the modules to include for each layer
            'require' => array(
                'dojo/parser'
            ),
            'build' => array(
                'profilePath' => 'data/dojo-module.profile.js',
                'basePath' => '../',
                'releaseDir' => 'public/js/dojo_rel',
                'action' => 'release',
                'cssOptimize' => 'comments',
                'optimize' => 'closure',
                'layerOptimize' => 'closure',
                'stripConsole' => 'all',
                'selectorEngine' => 'acme',
                'mini' => 1,
                'packages' => array(
                    'dojo' => 'vendor/dojo/dojo',
                    'dijit' => 'vendor/dojo/dijit',
                    'dojox' => 'vendor/dojo/dojox',
                    'Sds' => 'vendor/dojo/Sds'
                ),
                'plugins' => array(
                    'Sds/ConfigManager/ConfigReady' => 'Sds/Build/Plugin/ConfigReady',
                    'Sds/ServiceManager/SharedServiceManager' => 'Sds/Build/Plugin/SharedServiceManager',
                    'Sds/ServiceManager/Shared/GetObject' => 'Sds/Build/Plugin/CreateObject',
                    'Sds/ServiceManager/Shared/CreateObject' => 'Sds/Build/Plugin/CreateObject'
                ),
                'layers' => array(
                    'dojo/dojo' => array(
                        'custombase' => true,
                        'boot' => true,
                        'include' => array(
                            'dojo/parser'
                        )
                    ),
                    'Sds/AuthModule' => array(
                        'include' => array(
                            'Sds/AuthModule/AuthController'
                        )
                    )
                ),
            ),
            'stylesheets' => array(
                'dojo/parser' => array(
                    'dojo/resources/dojo.css',
                    'dijit/themes/[THEME]/[THEME].css'
                ),
                'dojox/grid/enhancedGrid' => array(
                    'dojox/grid/enhanced/resources/[THEME]/EnhancedGrid.css',
                    'dojox/grid/enhanced/resources/EnhancedGrid_rtl.css',
                ),
                'dojox/form/checkedMultiSelect' => array(
                    'dojox/form/resources/CheckedMultiSelect.css',
                ),
                'dojox/widget/standby' => array(
                    'dojox/widget/Standby/Standby.css',
                ),
                'dojox/form/uploaderFilelist' => array(
                    'dojox/form/resources/UploaderFileList.css',
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'sds.dojo.cli' => 'Sds\DojoModule\Service\CliFactory',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'Dojo' => 'Sds\DojoModule\View\Helper\DojoFactory',
        ),
    ),
);

