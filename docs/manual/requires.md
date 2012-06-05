DojoModule
==========

## Adding Required Modules

Add any dojo modules you want to use to the `requires` array of a config file. Eg:

    'dojo' => array(
        'require' => array(
            'button',                
        ),
    ),

For convenience, you can simply uncomment the desired lines in the `module.dojo.global.php` config file.

DojoModule does not detect and automatically add Dojo requires like Zend/Dojo did in zf1.