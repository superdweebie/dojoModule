<?php
/**
 * @package    DojoModule
 * @copyright  Copyright (c) 2012 Tim Roediger
 * @license    LGPL
 */
namespace DojoModule\View\Helper;

use Zend\View\Exception,
    Zend\View\Helper\AbstractHelper,    
    Zend\View\Renderer;

class Dojo extends AbstractHelper {
    
    protected $modules = array();
    protected $dojoRoot;
    protected $theme;

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

    public function getModule($functionName){
        return $this->modules[$functionName];
    }
    
    public function addModule($functionName, Module $module){
        $this->modules[$functionName] = $module;
    }
        
    public function __invoke() {
        return $this;
    }
    
    public function activate(){
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
      
    public function __call($method, $argv)
    {
        if ($argv){
            $module = $this->getModule($method);
            return $module->render($argv[0]);
        } else {
            return $this->getModule($method);
        }
    }       
}
