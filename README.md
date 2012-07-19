DojoModule
==========

## Introduction

DojoModule is a module for Zend Framework 2 that will enable easy use of Dojo 1.7.

## Installation

DojoModule uses composer to install.

Add the following to your project root composer.json:

    {
        "repositories": [{ "type": "composer", "url": "https://raw.github.com/superdweebie/dojoModule/master" }],
        "require": {
            "superdweebie/DojoModule": "dev-master"
        }
    }

## Adding Required Modules

Add any dojo modules you want to use to the `require` array of a config file. Eg:

    'sds' => array(
        'dojo' => array(
            'require' => array(
                'dijit\forms\Button',
            ),
        ),
    ),

## Adding Stylesheets

Add any dojo related css you want to use to the `stylesheet` array of a config file. Any
[THEME] references will be replaced with the configured dojo theme name. Eg:

    'sds' => array(
        'dojo' => array(
            'stylesheets' => array(
                'dojo/parser' => array(
                    'dojo/resources/dojo.css',
                    'dijit/themes/[THEME]/[THEME].css'
                ),
            ),
        ),
    ),

## Basic DojoModule Usage

If you wish to use dojo, place the following line at the beginning of your view script:

    $this->dojo()->activate();

Also make sure the following lines are in your view script, after the activation call shown above:

    <?php echo $this->headLink() ?>
    <?php echo $this->headScript() ?>

Finally, get the theme for use in the body tag:

    <body class="<?php echo $this->dojo()->getTheme();?>">

## Dojo builds

Build profiles can be made by executing `vendor/bin/dojo-module`
