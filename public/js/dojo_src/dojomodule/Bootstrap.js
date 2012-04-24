/**
 * @package    DojoModule
 * @copyright  Copyright (c) 2012 Tim Roediger
 * @license    LGPL
 */
define
(
    [
        'dojo/_base/declare',
        'dijit/_Widget'     
    ], 
    function(declare, _Widget)
    {       
        return declare
        (
            'dojomodule.Bootstrap',
            [_Widget],
            {}
        );
    }
);
