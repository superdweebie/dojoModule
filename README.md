DojoModule
==========

## Introduction
DojoModule is a module for Zend Framework 2 that will enable easy use of Dojo 1.7. It aims to be a lighter version of what was available with ZF1.

    -View helpers are supported. New dojo module helpers can be configured with the DI, no new classes needed.
    -Forms are not supported. Zend\Form isn't a great fit with Dojo, and it makes the integration much more complex. (As a suggestions, rather than using Zend\Form, use a view script with the view helpers, and feed form data back through a Dojo object store to a Json controller. Then validate the form data against your model, rather than against the form.)
    -Dojo layers are not supported at present, but will be.

This is an unfinished work. Please extend and improve liberally.

## Requirements
  * Zend Framework 2 (https://github.com/zendframework/zf2)
  
## Installation

You can add this as a submodule to your own .git repository:

    cd /to/your/project/directory
    git submodule add git://github.com/superdweebie/DojoModule  vendor/DojoModule

Then fetch the dojo submodules with:

    cd vendor/DojoModule
    git submodule update --init

### Make public files accessable
Copy or symlink all the files in the DojoModule/public/js directory into your application public/js directory
	
## Configuration

Open `/config/application.config.php` and add 'DojoModule'
to the 'modules' parameter to register the module within your application.

Copy the from the module, move `config/module.dojomodule.global.config.php.dist` to your `/config/autoload` directory, and remove the `dist` suffix.

Open module.dojomodule.global.config.php and uncomment any modules you want to use.

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

If you want to add further dojo modules, add the following to the DI config:

    'instance' => array(
        'alias' => array(
            'dojo_mymodule' => 'DojoModule\View\Helper\Module'
        )

        'dojo_mymodule' => array(
            'parameters' => array(
                'name' => 'mydojo.mymodule',
                'stylesheets' => array(
                    '/mydojo/resources/mymodule.css',                         
                )                    
            )
        ),

        'DojoModule\View\Helper\Dojo' => array(
            'injections' => array(
                'addModule' => array(
                    array('functionName' => 'mymodule', 'module' => 'dojo_mymodule'),                    
                )
            ),                   
        ),
    )

Then to use your module in a view script:
    
    echo $this->dojo()->mymodule(array('id' => 'mymoduleid'))

## Generating Dojo layers
Integration with the dojo build tools is still to be done (want to help?). But,
you can get a list of all the modules loaded with $this->dojo()->getModules();
