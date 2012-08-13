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
                'dojo/parser' => array(
                    'dojo/dojo'
                )
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
                'packages' => array(
                    'dojo' => 'vendor/dojo/dojo',
                    'dijit' => 'vendor/dojo/dijit',
                    'dojox' => 'vendor/dojo/dojox'
                ),
                'layers' => array(
                    'dojo/dojo' => array(
                        'custombase' => true,
                        'boot' => true,
                    ),
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

