<?php
return array(
    'view_manager' => array(
        'helper_map' => array(
            'dojo' => 'DojoModule\View\Helper\Dojo'
        ),
    ),
    'dojo' => array(
        'activeDojoRoot' => 'release',
        'dojoRoots' => array(
            'source' => '/js/dojo_src',
            'release' => '/js/dojo_rel'
        ),
        'build' => array(
            'profile' => 'data/dojoModule.profile.js',
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
            'parser',                
        ),
        'modules' => array(
            'dojo' => array(
                'name' => 'dojo/dojo'
            ),
            'parser' => array(
                'name' => 'dojo/parser',
                'stylesheets' => array(
                    'dojo/resources/dojo.css',
                    'dijit/themes/[THEME]/[THEME].css'                         
                )
            ),                                                   
            'borderContainer' => array(
                'name' => 'dijit/layout/BorderContainer'
            ),            
            'contentPane' => array(
                'name' => 'dijit/layout/ContentPane'
            ),            
            'button' => array(
                'name' => 'dijit/form/Button'
            ),                         
            'enhancedGrid' => array(
                'name' => 'dojox/grid/EnhancedGrid',
                'stylesheets' => array(
                    'dojox/grid/enhanced/resources/[THEME]/EnhancedGrid.css', 
                    'dojox/grid/enhanced/resources/EnhancedGrid_rtl.css',                        
                )                    
            ),            
            'checkedMultiSelect' => array(
                'name' => 'dojox/form/CheckedMultiSelect',
                'stylesheets' => array(
                    'dojox/form/resources/CheckedMultiSelect.css',                  
                )                    
            ),            
            'standby' => array(
                'name' => 'dojox/widget/standby',
                'stylesheets' => array(
                    'dojox/widget/Standby/Standby.css',               
                )                    
            ),            
            'uploader' => array(
                'name' => 'dojox/form/Uploader',                   
            ),            
            'uploaderFilelist' => array(
                'name' => 'dojox/form/uploader/FileList',
                'stylesheets' => array(
                    'dojox/form/resources/UploaderFileList.css',               
                )                    
            ),            
            'uploaderHtml5' => array(
                'name' => 'dojox/form/uploader/plugins/HTML5',              
            ),                    
        ),
    ),
);

