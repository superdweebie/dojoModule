DojoModule
==========

## Introduction
DojoModule is a module for Zend Framework 2 that will enable easy use of Dojo 1.7.

    -View helpers are supported. New dojo module helpers can be configured with the module config only, no need to write new classes.
    -Forms are not supported at this point.
    -Dojo build profiles are supported.

This is an unfinished work. Please extend and improve liberally.

## Requirements
  * Zend Framework 2 (https://github.com/zendframework/zf2)
  
## Installation Packages

DojoModule uses composer to install.

Add the following to your project root composer.json:

    {
        "repositories": [
            {        
                "type": "package",
                "package": {
                    "name": "dojo/dojo",
                    "version": "1.7.2",
                    "source": {
                        "url": "http://github.com/dojo/dojo",
                        "type": "git",
                        "reference": "1.7.2"
                    }
                }
            },
            {        
                "type": "package",
                "package": {
                    "name": "dojo/dijit",
                    "version": "1.7.2",
                    "source": {
                        "url": "http://github.com/dojo/dijit",
                        "type": "git",
                        "reference": "1.7.2"
                    }
                }
            },
            {        
                "type": "package",
                "package": {
                    "name": "dojo/dojox",
                    "version": "1.7.2",
                    "source": {
                        "url": "http://github.com/dojo/dojox",
                        "type": "git",
                        "reference": "1.7.2"
                    }
                }
            },
            {        
                "type": "package",
                "package": {
                    "name": "dojo/util",
                    "version": "1.7.2",
                    "source": {
                        "url": "http://github.com/dojo/util",
                        "type": "git",
                        "reference": "1.7.2"
                    }
                }
            }        
        ], 
        "require": {
            "superdweebie/DojoModule": "dev-master",       
        }
    }

Then run composer from your project root:

    composer.phar install

Open your application.config.php and add `DojoModule`.

##Installing built Dojo

DojoModule will help build dojo for you. This is the quickest and simplest way to get started, however,
if you are developing your own dojo modules, you will want to intall the Dojo source as 
outlined below.

To build dojo, first create a build profile. Go to directory:

    vendor/bin

And run:

    dojo-module profile

This will create a build profile at data/dojoModule.profile.js

Then got to directory:

    vendor/dojo/util/buildscripts

And run:

    build --profile data\dojoModule.profile.js

Dojo will be built to `public\js\dojo_rel`

##Installing Dojo source

Under your project's public directory, create the following new directory:

    myproject/public/js/dojo_src/

Then copy or symlink the following directories:

    myproject/vendor/dojo/dojo -> myproject/public/js/dojo_src/dojo
    myproject/vendor/dojo/dijit -> myproject/public/js/dojo_src/dijit
    myproject/vendor/dojo/dojox -> myproject/public/js/dojo_src/dojox

Finally, add the following to application.config.php:

    'dojo' => array(
        'activeDojoRoot' => 'source',
    )
	
## Configuration

Add any dojo modules you want to use to the `requires` array of a config file. Eg:

    'dojo' => array(
        'require' => array(
            'button',                
        ),
    ),

## Basic DojoModule Usage

If you wish to use dojo, place the following line at the beginning of your view script:

    $this->dojo()->activate();

Also make sure the following lines are in your view script, after the activation call shown above:

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

If you want to add further dojo modules, add to the `modules` array in a config. You can overide
module configs, and specify stylesheets.

## Customising Dojo build

Overide the `build` array in config and follow the insturctions under Installing Built Dojo
