<?php
/**
 * @package    DojoModule
 * @license    LGPL
 */
namespace DojoModule\View\Helper;

use Zend\View\Exception,
    Zend\View\Helper\AbstractHelper,    
    Zend\View\Renderer;

/**
 * View helper for emitting Dojo elements as HTML
 * 
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Dojo extends AbstractHelper {

    /**
     * An array of \DojoModule\View\Heper\Module instances which are 
     * available for the view helper to use.
     *
     * @var Array
     */    
    protected $modules = array();
    
    /**
     * The root path on disk of the dojo js files, relative to the zf2 
     * public directory.
     *
     * @var Array
     */      
    protected $dojoRoot;
    
    /**
     * The name of the dojo theme to use.
     *
     * @var Array
     */       
    protected $theme;

    /**
     * Sets the dojo theme to use.
     *
     * @param string $theme
     * @return \DojoModule\View\Helper\Dojo
     */    
    public function setTheme($theme) {
        $this->theme = (string) $theme;
        return $this;
    }    
    
    /**
     * Gets the dojo theme.
     *
     * @return string
     */      
    public function getTheme() {
        return $this->theme;
    }    

    /**
     * Sets the root path on disk of the dojo js files, relative to the zf2 
     * public directory.
     *
     * @param string $dojoRoot
     * @return \DojoModule\View\Helper\Dojo
     */     
    public function setDojoRoot($dojoRoot) {
        $this->dojoRoot = (string) $dojoRoot;
        return $this;
    }

    /**
     * Gets the dojo root path, relative to the public directory.
     *
     * @return string
     */       
    public function getDojoRoot() {
        return $this->dojoRoot;
    }

    /**
     * Gets an array of available dojo modules.
     *
     * @return array
     */       
    public function getModules() {
        return $this->modules;        
    }

    /**
     * Sets an array of \DojoModule\View\Heper\Module instances which are 
     * available for the view helper to use.
     *
     * @param array $modules
     * @return \DojoModule\View\Helper\Dojo
     */     
    public function setModules(array $modules) {
        $this->modules = $modules;
        return $this;
    }

    /**
     * Gets a single module.
     *
     * @param string $functionName
     * @return \DojoModule\View\Helper\Module
     */      
    public function getModule($functionName){
        return $this->modules[$functionName];
    }
    
    /**
     * Adds a \DojoModule\View\Heper\Module instance so it is ready for the 
     * view helper to use. The $functionName is the alias that is used to call the
     * module inside a view script: eg `$this->dojo()->myFunctionName(args)`
     *
     * @param string $functionName
     * @param \DojoModule\View\Heper\Module $module
     * @return \DojoModule\View\Helper\Dojo
     */    
    public function addModule($functionName, Module $module){
        $this->modules[(string)$functionName] = $module;
        return $this;
    }
        
    /**
     * Does nothing.
     *
     * @return \DojoModule\View\Helper\Module
     */       
    public function __invoke() {
        return $this;
    }
    
    /**
     * Method should be used at the very top of a view script. Inserts all the 
     * required script and stylesheets for dojo into the headScript and headLink 
     * view helpers respectively.
     *
     */        
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
      
    /**
     * Used to retrieve and render a single module. getModule() may be used as an alternate.
     * 
     * @param string $method
     * @param array $argv
     * @return mixed
     */      
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
