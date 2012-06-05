DojoModule
==========

## Installation of Packages

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
            "dojo/dojo" : "1.7.*",
            "dojo/dijit" : "1.7.*",
            "dojo/dojox" : "1.7.*",
            "dojo/util" : "1.7.*"     
        }
    }

Then run composer from your project root:

    composer.phar install

Open your application.config.php and add `DojoModule`.

Finally, copy `module.dojo.global.php.dist` to your `config/autoload` directory and rename.

##Making Dojo accessable

The dojo javascript files need to be available to the client. There are two ways you can do this:

###Build Dojo

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

###Use Dojo source

Under your project's public directory, create the following new directory:

    myproject/public/js/dojo_src/

Then copy or symlink the following directories:

    myproject/vendor/dojo/dojo -> myproject/public/js/dojo_src/dojo
    myproject/vendor/dojo/dijit -> myproject/public/js/dojo_src/dijit
    myproject/vendor/dojo/dojox -> myproject/public/js/dojo_src/dojox

Finally, add the following to `module.dojo.global.php.dist`:

    'dojo' => array(
        'activeDojoRoot' => 'source',
    )
