<?php
return array(
    'di' => array(
        'instance' => array(

            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'dojo' => 'DojoModule\View\Helper\Dojo',
                    ),
                )
            ),         
            
            //register dojo view helpers
            'DojoModule\View\Helper\Dojo' => array(
                'parameters' => array(
                    'view' => 'Zend\View\Renderer\PhpRenderer',
                    'broker' => 'Zend\View\HelperBroker',                    
                    'plugins' => array(
                        'bootstrap' => 'DojoModule\View\Helper\Dojo\Bootstrap',
                        'borderContainer' => 'DojoModule\View\Helper\Dojo\BorderContainer',          
                        'contentPane' => 'DojoModule\View\Helper\Dojo\ContentPane',                                     
                        'button' => 'DojoModule\View\Helper\Dojo\Button',                             
                    ),
                    'bootstrapModule' => 'DojoModule\View\Helper\Dojo\Bootstrap',
                    'dojoRoot' => 'js/dojo_src',
                    'stylesheets' => array(
                        '/dojo/resources/dojo.css',
                        '/dijit/themes/[THEME]/[THEME].css'                        
                    ),
                    'theme' => 'claro'
                ),                    
            ),
            
            'DojoModule\View\Helper\Dojo\Bootstrap' => array(
                'parameters' => array(
                    'module' => 'dojomodule.Bootstrap'
                )
            ),     
            
            'DojoModule\View\Helper\Dojo\BorderContainer' => array(
                'parameters' => array(
                    'module' => 'dijit.layout.BorderContainer'
                )
            ),
            
            'DojoModule\View\Helper\Dojo\ContentPane' => array(
                'parameters' => array(
                    'module' => 'dijit.layout.ContentPane'
                )
            ),
            
            'DojoModule\View\Helper\Dojo\Button' => array(
                'parameters' => array(
                    'module' => 'dijit.form.Button'
                )
            ),            
        ),
    ),
);

