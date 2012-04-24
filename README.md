DojoModule
==========

## Introduction
DojoModule is a module for Zend Framework 2 that will enable easy use of Dojo 1.7. It aim to replace some of the functionality from the old Dojo package that was part of zf1. DojoModule aims to be lighter than the previous package.

This is an unfinished work. (Only four view helpers exist so far!) Please extend and improve liberally.

## Requirements
  * Zend Framework 2 (https://github.com/zendframework/zf2)
  
## Installation
### Easy peasy
The easiest way to get a working copy of this project is to do a recursive clone:

    cd /to/your/project/directory
    git clone --recursive git://github.com/superdweebie/DojoModule vendor/DojoModule

### Easy peasy v2
Or you can add this as a submodule to your .git repository

    cd /to/your/project/directory
    git submodule add git://github.com/superdweebie/DojoModule  vendor/DojoModule

### Copy files into public
Copy all the files in the DojoModule/public/js directory into your applications public/js directory
	
## Configuration

Open `.../configs/application.config.php` and add 'DojoModule'
to the 'modules' parameter to register the module within your application.
	
## Basic DojoModule Usage

If you wish to use dojo, place the following lines in your view script

    $this->dojo()->activate();

Also make sure the following lines are somewhere in your view script, after the activation call shown above:

    <?php echo $this->headLink() ?>
    <?php echo $this->headScript() ?>   

Use the view helpers like you would other view helpers.

Get the them for use in the body tag:

    <body class="<?php echo $this->dojo()->getTheme();?>">

Construct an element:

    echo $this->dojo()->button(array('id' => 'button', 'dojoAttr' => array('label' => "'this is a button'")));  

Construct a container element:

    $this->dojo()->borderContainer()->captureStart(array('id' => 'mainPane', 'dojoAttr' => array('gutters' => 'false')));
        //some content
    echo $this->dojo()->contentPane()->captureEnd('topPane');

The arguments for the view helpers is an options array. The following values will be utilised if found:
* id: string / the id of the element.
* htmlAttr: array of strings / will be rendered as attribues of the element
* dojoAttr: array of strings / will be rendered as inside the data-dojo-props attribue
* content: string / will be rendered inside the element tags

## Overriding and extending config

If you write your own dojo modules that extend the standard dojo modules, may over ride the default config of a view helper to render your extended module. eg:

	'DojoModule\View\Helper\Dojo\Button' => array(
		'parameters' => array(
			'module' => 'mydojo.MyButton'
		)
	),     

To add more stylesheets, change the dojo root, add extra view helpers, or change the theme, simply override the Dojo config. eg:

	'DojoModule\View\Helper\Dojo' => array(
		'parameters' => array(
			'plugins' => array(
				'extraPlugin' => 'Application\View\Helper\Dojo\ExtraPlugin',                              
			),
			'stylesheets' => array(
				'/dojox/grid/enhanced/resources/[THEME]/EnhancedGrid.css',
				'/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css',
			)
			'theme' => 'mytheme'
		),                    
	),
	
## Using the dojo bootrstrap

A skeleton bootstrap class is provided in the DojoModule/public/js/dojo_src/dojomodule directory. You can extend this class to load all the dojo modules required by your application, and run any startup code. The example below is an extended bootstrap module. It loads all the required modules, including multiple custom 'sds' modules. Then in the startup function it does some initalisation of those custom modules, and animates a splash screen.

    define([
        'dojo/_base/declare',  
        'dojo/dom',
        'dojo/_base/lang',     
        'dojo/_base/fx',          
        'sds/services/_Services',
        'dojomodule/Bootstrap',        
        'dijit/layout/BorderContainer',
        'dijit/layout/ContentPane',        
        'sds/ActiveUser',        
        'sds/PageTitle',
        'sds/Status'        
    ], 
    function(declare, dom, lang, fx, _Services, Bootstrap)
    {       
        return declare
        (
            'sds.Bootstrap',
            [_Services, Bootstrap],
            {
                activeUser: undefined,
                pageTitle: undefined,
                status: undefined,
                loginConfig: undefined,
                startup: function()
                {
                    this.activeUserService.setUser(this.activeUser);
                    this.pageTitleService.setTitle(this.pageTitle);                
                    this.statusService.setStatus(this.status);
                    this.loginService.setConfig(this.loginConfig);                  
                    this.fadeAnim = fx.animateProperty
                    (
                        {
                            node: dom.byId('splashPane'),
                            properties: 
                            {
                                opacity: 0
                            },
                            onEnd: lang.hitch
                            (
                                this, 
                                function()
                                {
                                    this.fadeAnim = null;
                                }
                            )
                        }
                    );
                    this.fadeAnim.play();    
                    
                    this.errorService.handle({accessDenied: true});
                }
            }
        );
    });

Tell DojoModule to use your extended bootstrap class with the following config override:

	'DojoModule\View\Helper\Dojo\Bootstrap' => array(
		'parameters' => array(
			'module' => 'sds.Bootstrap'
		)
	),   

Finally, use the bootstrap view helper in a view, and pass any initalisation variable you wish. eg:

    echo $this->dojo()->bootstrap(array(
        'id' => 'bootstrap',
        'dojoAttr' => array(
            'activeUser' => null,
            'pageTitle' => "{main: 'main', sub: 'sub'}",
            'status' => "{message: 'welcome', icon: 'happy', timeout: 5000}",
            'loginConfig' => "{loginUrl: '$siteUrl/login', logoutUrl: '$siteUrl/logout'}"
        )
    ));
	
Using a dojo bootstrap like this had the added advantage of making the construction of a dojo layer very straightforward, because all your depenancies are defined in the bootstrap module.
