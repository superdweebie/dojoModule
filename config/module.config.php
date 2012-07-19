<?php
return array(
    'sds' => array(
        'dojo' => array(
            'activeDojoRoot' => 'release',
            'dojoRoots' => array(
                'source' => 'js/dojo_src',
                'release' => 'js/dojo_rel'
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
            ),
            'theme' => 'claro',
            'require' => array(
                'dojo/parser'
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

