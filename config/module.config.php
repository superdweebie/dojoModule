<?php
return array(
    'view_manager' => array(
        'helper_map' => array(
            'dojo' => 'DojoModule\View\Helper\Dojo'
        )        
    ),

    'di' => array(                
        'instance' => array(                              
    
            'Application\Controller\IndexController' => array(
                'parameters' => array(
                    'documentManager' => 'mongo_dm',
                    'activeUser' => 'active_user',                    
                )
            ),                    
            
            'sdsDojo_bootstrap' => array(
                'parameters' => array(
                    'stylesheets' => array(
                        '/application/themes/[THEME]/[THEME].css',                 
                    )                    
                )
            ),                           
        ),
    ),
    
    'di' => array(
        'definition' => array(        
            'class' => array(
                'DojoModule\View\Helper\Dojo' => array(
                    'addModule' => array(
                        'functionName' => array(
                            'type' => false, 
                            'required' => true
                        ),
                        'module' => array(
                            'type' => 'DojoModule\View\Helper\Module', 
                            'required' => true
                        )                    
                    )
                )
            ),    
        ),
        'instance' => array(
            'alias' => array(
                'dojo_parser' => 'DojoModule\View\Helper\Module',                
                'dojo_borderContainer' => 'DojoModule\View\Helper\Module',
                'dojo_contentPane' => 'DojoModule\View\Helper\Module',
                'dojo_button' => 'DojoModule\View\Helper\Module',                
                'dojo_enhancedGrid' => 'DojoModule\View\Helper\Module',      
                'dojo_checkedMultiSelect' => 'DojoModule\View\Helper\Module',      
                'dojo_standby' => 'DojoModule\View\Helper\Module',                      
                'dojo_uploader' => 'DojoModule\View\Helper\Module', 
                'dojo_uploader_filelist' => 'DojoModule\View\Helper\Module', 
                'dojo_uploader_html5' => 'DojoModule\View\Helper\Module',                 
            ),
            
            //register dojo view helpers                                         
            'DojoModule\View\Helper\Dojo' => array(
                'injections' => array(
                    'addModule' => array(
                        array('functionName' => 'parser', 'module' => 'dojo_parser'),                    
                    )
                ),  
                'parameters' => array(                
                    'dojoRoot' => 'js/dojo_src',
                    'theme' => 'claro',
                    'view' => 'Zend\View\Renderer\PhpRenderer'
                ),                 
            ),
            
            'DojoModule\View\Helper\Module' => array(
                'parameters' => array(                
                    'view' => 'Zend\View\Renderer\PhpRenderer'
                ),                 
            ),
            
            'dojo_parser' => array(
                'parameters' => array(
                    'name' => 'dojo.parser',
                    'stylesheets' => array(
                        '/dojo/resources/dojo.css',
                        '/dijit/themes/[THEME]/[THEME].css'                         
                    )
                )
            ),     
            
            'dojo_borderContainer' => array(
                'parameters' => array(
                    'name' => 'dijit.layout.BorderContainer'
                )
            ),
            
            'dojo_contentPane' => array(
                'parameters' => array(
                    'name' => 'dijit.layout.ContentPane'
                )
            ),
            
            'dojo_button' => array(
                'parameters' => array(
                    'name' => 'dijit.form.Button'
                )
            ), 
                        
            'dojo_enhancedGrid' => array(
                'parameters' => array(
                    'name' => 'dojox.grid.EnhancedGrid',
                    'stylesheets' => array(
                        '/dojox/grid/enhanced/resources/[THEME]/EnhancedGrid.css', 
                        '/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css',                        
                    )                    
                )
            ),
            
            'dojo_checkedMultiSelect' => array(
                'parameters' => array(
                    'name' => 'dojox.form.CheckedMultiSelect',
                    'stylesheets' => array(
                        '/dojox/form/resources/CheckedMultiSelect.css',                  
                    )                    
                )
            ),
            
            'dojo_standby' => array(
                'parameters' => array(
                    'name' => 'dojox.widget.standby',
                    'stylesheets' => array(
                        '/dojox/widget/Standby/Standby.css',               
                    )                    
                )
            ),
            
            'dojo_uploader' => array(
                'parameters' => array(
                    'name' => 'dojox/form/Uploader',                   
                )
            ),
            
            'dojo_uploader_filelist' => array(
                'parameters' => array(
                    'name' => 'dojox.form.uploader.FileList',
                    'stylesheets' => array(
                        'dojox/form/resources/UploaderFileList.css',               
                    )                    
                )
            ),
            
            'dojo_uploader_html5' => array(
                'parameters' => array(
                    'name' => 'dojox.form.uploader.plugins.HTML5',              
                )
            ),                    
        ),
    ),
);

