<?php
/**
 * @package    DojoModule
 * @copyright  Copyright (c) 2012 Tim Roediger
 * @license    LGPL
 */
namespace DojoModule\View\Helper\Dojo;

use Zend\View\Exception,
    Zend\View\Helper\HtmlElement;

abstract class Element extends HtmlElement
{

    protected $rootNode = 'div';
    protected $module = '';
    
    public function setRootNode($rootNode)
    {
        $this->rootNode = $rootNode;
    }
    
    public function setModule($module)
    {
        $this->module = $module;
    }
    
    public function getModule()
    {
        return $this->module;
    }
    
    public function __invoke(array $options = array())
    {
        $id = array_key_exists('id', $options) ? $options['id'] : array();        
        $htmlAttr = array_key_exists('htmlAttr', $options) ? $options['htmlAttr'] : array();
        $dojoAttr = array_key_exists('dojoAttr', $options) ? $options['dojoAttr'] : array();        
        $content = array_key_exists('content', $options) ? $options['content'] : '';
        
        $htmlAttr['id'] = $id;
        $htmlAttr['data-dojo-type'] = $this->module;
        $htmlAttr['data-dojo-props'] = $this->_formatDojoAttr($dojoAttr);
        $html = '<' . $this->rootNode . $this->_htmlAttribs($htmlAttr) . '>'
              . $content
              . '</'.$this->rootNode.'>'.self::EOL;
        
        return $html;
    }
    
    protected function _formatDojoAttr($dojoAttr)
    {
        $props = '';
        foreach ($dojoAttr as $key => $value)
        {
            if ($value === false)
            {
                $props .= $key.': false, ';                
            } else {
                if ($value === true)
                {
                    $props .= $key.': true, ';                          
                } else {
                    if($value != null)
                    {
                        $props .= $key.':'.$value.', ';                    
                    }
                }
            }
        }
        $props =  substr($props, 0, -2);
        return $props;
    }
}
