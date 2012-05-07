<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'dojo_bootsrap' => 'DojoModule\View\Helper\Element',
                'dojo_borderContainer' => 'DojoModule\View\Helper\Element',
                'dojo_contentPane' => 'DojoModule\View\Helper\Element',
                'dojo_button' => 'DojoModule\View\Helper\Element',                
                'dojo_enhancedGrid' => 'DojoModule\View\Helper\Element',      
                'dojo_checkedMultiSelect' => 'DojoModule\View\Helper\Element',      
                'dojo_standby' => 'DojoModule\View\Helper\Element',                      
            ),
            
            //register dojo view helpers            
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'dojo' => 'DojoModule\View\Helper\Dojo',
                    ),
                )
            ),         
            
            'DojoModule\View\Helper\Dojo' => array(
                'parameters' => array(                
                    'modules' => array(
                        'bootstrap' => 'dojo_bootsrap',                      
                    ),
                    'dojoRoot' => 'js/dojo_src',
                    'theme' => 'claro',
                    'view' => 'Zend\View\Renderer\PhpRenderer'
                ),                    
            ),
            
            'dojo_bootstrap' => array(
                'parameters' => array(
                    'module' => 'dojomodule.Bootstrap',
                    'stylesheets' => array(
                        '/dojo/resources/dojo.css',
                        '/dijit/themes/[THEME]/[THEME].css'                         
                    )
                )
            ),     
            
            'dojo_borderContainer' => array(
                'parameters' => array(
                    'module' => 'dijit.layout.BorderContainer'
                )
            ),
            
            'dojo_contentPane' => array(
                'parameters' => array(
                    'module' => 'dijit.layout.ContentPane'
                )
            ),
            
            'dojo_button' => array(
                'parameters' => array(
                    'module' => 'dijit.form.Button'
                )
            ), 
                        
            'dojo_enhancedGrid' => array(
                'parameters' => array(
                    'module' => 'dojox.grid.EnhancedGrid',
                    'stylesheets' => array(
                        '/dojox/grid/enhanced/resources/[THEME]/EnhancedGrid.css', 
                        '/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css',                        
                    )                    
                )
            ),
            
            'dojo_checkedMultiSelect' => array(
                'parameters' => array(
                    'module' => 'dojox.form.CheckedMultiSelect',
                    'stylesheets' => array(
                        '/dojox/form/resources/CheckedMultiSelect.css',                  
                    )                    
                )
            ),
            
            'dojo_standby' => array(
                'parameters' => array(
                    'module' => 'dojox.widget.standby',
                    'stylesheets' => array(
                        '/dojox/widget/Standby/Standby.css',               
                    )                    
                )
            ),
            
            //                        'resources/UploaderFileList.css'
        ),
    ),
);

