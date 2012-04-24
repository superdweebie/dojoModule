<?php
/**
 * @package    DojoModule
 * @copyright  Copyright (c) 2012 Tim Roediger
 * @license    LGPL
 */
namespace DojoModule\View\Helper;

use Zend\View\Exception,
    Zend\View\HelperBroker,    
    Zend\View\Helper\AbstractHelper,
    Zend\View\Renderer;

class Dojo extends AbstractHelper
{

    /**
     * Helper broker
     *
     * @var HelperBroker
     */
    private $__helperBroker;
    
    protected $dojoRoot;
    protected $plugins;
    protected $bootstrapModule;
    protected $view;
    protected $stylesheets = array();
    protected $theme;
    
    public function __invoke()
    {
        return $this;
    }
    
    public function activate()
    {
        $view = $this->view;
        $bootstrap = $this->bootstrapModule->getModule();
        $bootstrap = str_replace('.', '/', $bootstrap);           
        $view->headScript()
            ->setAllowArbitraryAttributes(true)
            ->appendFile($this->dojoRoot.'/dojo/dojo.js', 'text/javascript', array('data-dojo-config' => 'async: true, baseUrl: "/js/dojo_src/dojo"' 
                ))
            ->appendScript("
    require(
        ['dojo/parser', '$bootstrap', 'dojo/domReady!'], 
        function(parser) {parser.parse();}
    );          
                ");
        
        foreach ($this->stylesheets as $stylesheet)
        {
            $stylesheet = $this->dojoRoot . str_replace('[THEME]', $this->theme, $stylesheet);
            $view->headLink()->appendStylesheet($stylesheet);
        }
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }    
    
    public function getTheme()
    {
        return $this->theme;
    }
    
    public function setView(Renderer $view)
    {
        $this->view = $view;
        return $this;
    }
    
    public function setPlugins(array $plugins)
    {
        $this->plugins = $plugins;
        return $this;
    }
    
    public function setDojoRoot($dojoRoot)
    {
        $this->dojoRoot = $dojoRoot;
        return $this;
    }
    
    public function setStylesheets(array $stylesheets)
    {
        $this->stylesheets = $stylesheets;
    }
    
    public function setBootstrapModule(Dojo\Element $bootstrapModule)
    {
        $this->bootstrapModule = $bootstrapModule;
    }
    
    /**
     * Set plugin broker instance
     * 
     * @param  HelperBroker $broker 
     * @throws Exception\InvalidArgumentException
     */
    public function setBroker(HelperBroker $broker)
    {
        $broker->setView($this->view);
        $loader = $broker->getClassLoader();
        $loader->registerPlugins($this->plugins);
        $this->__helperBroker = $broker;
    }

    /**
     * Get plugin broker instance
     * 
     * @return HelperBroker
     */
    public function getBroker()
    {
        return $this->__helperBroker;
    }
    
    /**
     * Get plugin instance
     * 
     * @param  string     $plugin  Name of plugin to return
     * @param  null|array $options Options to pass to plugin constructor (if not already instantiated)
     * @return Helper
     */
    public function plugin($name, array $options = null)
    {
        return $this->getBroker()->load($name, $options);
    }

    /**
     * Overloading: proxy to helpers
     *
     * Proxies to the attached plugin broker to retrieve, return, and potentially
     * execute helpers.
     *
     * * If the helper does not define __invoke, it will be returned
     * * If the helper does define __invoke, it will be called as a functor
     * 
     * @param  string $method 
     * @param  array $argv 
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $helper = $this->plugin($method);
        if (is_callable($helper)) {
            return call_user_func_array($helper, $argv);
        }
        return $helper;
    }    
}
