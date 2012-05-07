<?php
/**
 * @package    DojoModule
 * @copyright  Copyright (c) 2012 Tim Roediger
 * @license    LGPL
 */
namespace DojoModule\View\Helper;

use Zend\View\Exception,
    Zend\View\Helper\HtmlElement,
    Zend\View\Renderer;

class Dojo extends HtmlElement
{
    
    protected $modules = array();
    protected $dojoRoot;
    protected $theme;

    public function __construct(array $modules, $dojoRoot, Renderer $view){
        $this->setModules($modules);
        $this->setDojoRoot($dojoRoot);
    }

    public function setTheme($theme) {
        $this->theme = (string) $theme;
        return $this;
    }    
    
    public function getTheme() {
        return $this->theme;
    }    
      
    public function setDojoRoot($dojoRoot) {
        $this->dojoRoot = (string) $dojoRoot;
        return $this;
    }
           
    public function getModules() {
        return $this->modules;        
    }

    public function setModules(array $modules) {
        $this->modules = $modules;
        return $this;
    }

    public function getModule($name){
        return $this->modules[$name];
    }
    
    public function setModule(Module $module){
        $this->module[] = $module;
    }
        
    public function __invoke()
    {
        $view= $this->view;         
        
        $requiredModules = array();
        foreach ($this->modules as $module){
            foreach ($module->getStylesheets() as $stylesheet)
            {
                $stylesheet = $this->dojoRoot . str_replace('[THEME]', $this->theme, $stylesheet);
                $view->headLink()->appendStylesheet($stylesheet);
            }
            $requiredModules[] = "'".str_replace('.', '/', $module->getName())."'";
        }

        $requiredModules =  implode(',', $requiredModules);
        $view->headScript()
            ->setAllowArbitraryAttributes(true)
            ->appendFile($this->dojoRoot.'/dojo/dojo.js', 'text/javascript', array('data-dojo-config' => 'async: true, baseUrl: "/js/dojo_src/dojo"' 
                ))
            ->appendScript("
require(
    ['dojo/parser', $requiredModules, 'dojo/domReady!'], 
    function(parser) {parser.parse();}
);"
                );        
    }
  
    public function render(
        $name, 
        array $htmlAttr = array(), 
        array $dojoAttr = array(),       
        $content = null
    ) {
        $element = $this->getElement($name);        
        $htmlAttr['data-dojo-type'] = $element->getModule();
        $htmlAttr['data-dojo-props'] = $this->_dojoAttr($dojoAttr);
        $html = '<' . $element->getRootNode() . $this->_htmlAttribs($htmlAttr) . '>'
              . $content
              . '</'.$element->getRootNode().'>'.self::EOL;        
        return $html;        
    }
    
    public function __call($method, $argv)
    {
        return $this->render($method, $argv[0], $argv[1], $argv[2]);
    } 
    
    protected function _dojoAttr($dojoAttr)
    {
        $props = '';
        foreach ($dojoAttr as $key => $value) {
            if ($value === false) {
                $props .= $key.': false, ';                
            } else {
                if ($value === true) {
                    $props .= $key.': true, ';                          
                } else {
                    if($value != null) {
                        $props .= $key.':'.$value.', ';                    
                    }
                }
            }
        }
        $props =  substr($props, 0, -2);
        return $props;
    }    
}
