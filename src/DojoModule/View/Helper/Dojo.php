<?php
/**
 * @package    DojoModule
 * @license    MIT
 */
namespace DojoModule\View\Helper;

use Zend\View\Exception;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer;
use DojoModule\View\Helper\Module;

/**
 * View helper for emitting Dojo elements as HTML
 * 
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Dojo extends AbstractHelper {

    /**
     * An array of \DojoModule\View\Heper\Module instances | config arrays which are 
     * available for the view helper to use.
     *
     * @var Array
     */    
    protected $modules = array();

    /**
     * An array of module aliases that must be emitted.
     *
     * @var Array
     */     
    protected $requireModules = array();
    
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
     * Sets an array of \DojoModule\View\Heper\Module instances | config arrays which are 
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
     * @param string $alias
     * @return \DojoModule\View\Helper\Module
     */      
    public function getModule($alias){
        if(!isset($this->modules[$alias])){
            throw new \Exception(sprintf('Dojo module with alias %s not found', $alias));
        }
        if(!($this->modules[$alias] instanceof Module)){
            $config = $this->modules[$alias];
            if(isset($config['class'] && $config['class'] != 'DojoModule\View\Helper\Module')){                
                $module = new {$config['class']}($config['name']);
            } else {
                $module = new Module($config['name']);
            }
            if(isset($config['rootNode'])){
                $module->setRootNode($config['rootNode']);
            }
            if(isset($config['stylesheets'])){
                $module->setStylesheets($config['stylesheets']);
            }
            $module->setView($this->view);
            $this->modules[$alias] = $module;
        }
        return $this->modules[$alias];
    }
    
    /**
     * Sets the array of module aliases that must be emited by the dojo.
     *
     * @param string $requireModules 
     * @return \DojoModule\View\Helper\Module
     */        
    public function setRequireModules(array $requireModules){
        $this->requireModules = $requireModules;
        return $this;
    }
    
    /**
     * Adds a module to the list of require modules that will be emitted by dojo.
     *
     * @param string $functionName
     * @param \DojoModule\View\Heper\Module $module
     * @return \DojoModule\View\Helper\Dojo
     */    
    public function addRequireModule($alias){
        
        $this->requireModules[] = (string) $alias;
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
        
        $requires = array();
        foreach ($this->requireModules as $alias){
            $module = $this->getModule($alias);
            foreach ($module->getStylesheets() as $stylesheet)
            {
                $stylesheet = $this->dojoRoot .'/'. str_replace('[THEME]', $this->theme, $stylesheet);
                $view->headLink()->appendStylesheet($stylesheet);
            }
            $requires[] = "'".$module->getName()."'";
        }

        $requires =  implode(',', $requires);
        $view->headScript()
            ->setAllowArbitraryAttributes(true)
            ->appendFile(
                $this->dojoRoot.'/dojo/dojo.js', 
                'text/javascript', 
                array('data-dojo-config' => 'async: true, baseUrl: "'.$this->dojoRoot.'/dojo"' )
            )
            ->appendScript("
                require(
                    [$requires, 'dojo/domReady!'], 
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