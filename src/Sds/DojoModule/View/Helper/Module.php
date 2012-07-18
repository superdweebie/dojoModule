<?php

/** 
 * @package    DojoModule 
 * @license    LGPL 
 */
namespace DojoModule\View\Helper;

use Zend\View\Helper\HtmlElement;

/** 
 * View helper that defines how to emit a single Dojo module as HTML 
 *  
 * @since   1.0 
 * @version $Revision$ 
 * @author  Tim Roediger <superdweebie@gmail.com> 
 */
class Module extends HtmlElement {

    /**
     * The name of the the dojo module. Eg: dijit.form.Button
     *
     * @var string
     */  
    protected $name;

    /**
     * The HTML tag used to encapsulate the Dojo module
     *
     * @var string
     */  
    protected $rootNode = 'div';

    /**
     * An array of strings which are paths to css files. Paths must be relative to the dojo root set in
     * /DojoModule/View/Helper/Dojo. If a path contains [THEME], then [THEME] will be replaced by the theme setting in
     * /DojoModule/View/Helper/Dojo.
     *
     * @var Array
     */  
    protected $stylesheets = array();
 
    /**
     * An array of ids which have been had the captureStart() function called, but not yet captureEnd().
     *
     * @var Array
     */     
    protected $captureLock = array();

    /**
     * An array of parameters held whist a capture is being undertaken.
     *
     * @var Array
     */  
    protected $captureInfo = array();
    
    /**
     * The dojo class name.
     *
     * @var Array
     */      
    protected $class;
    
    /**    
     * @param string $name
     * @return \DojoModule\View\Helper\Module
     */   
    public function __construct($name){
        $this->setName($name);
        return $this;
    }
    
    /**    
     * Get the name of the module, eg: dijit/form/button
     * 
     * @return string
     */     
    public function getName() {
        return $this->name;
    }

    /**    
     * Set the name of the module, eg: dijit/form/button
     * 
     * @param string $name
     * @return \DojoModule\View\Helper\Module
     */     
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**    
     * Get the dojo class name of the module, eg: dijit.form.button
     * 
     * @return string
     */     
    public function getClass() {
        if(!isset($this->class)){
            $this->class = str_replace('/', '.', $this->name);
        }
        return $this->class;
    }
    
    /**    
     * Get HTML tag that will enclose the rendered dojo module. Default 'div'.
     * 
     * @return string
     */      
    public function getRootNode() {
        return $this->rootNode;
    }

    /**    
     * Set HTML tag that will enclose the rendered dojo module.
     * 
     * @param string $name
     * @return \DojoModule\View\Helper\Module
     */     
    public function setRootNode($rootNode) {
        $this->rootNode = $rootNode;
        return $this;
    }    

    /**    
     * Get array of stylesheets associated with this module.
     * 
     * @return array
     */      
    public function getStylesheets() {
        return $this->stylesheets;
    }

    /**    
     * Set array of stylesheets associated with this module.
     * 
     * @param array $stylesheets
     * @return \DojoModule\View\Helper\Module
     */     
    public function setStylesheets($stylesheets) {
        $this->stylesheets = $stylesheets;
        return $this;
    } 
    
    /**    
     * Render the dojo module.
     * Options array has the following structure:
     * id: the id of the module
     * htmlAttr: array of strings to be rendered as html attributes
     * dojoAttr: array of strings to be rendered as dojo attributes
     *      
     * @param array $options
     * @return string The renered dojo module
     */      
    public function render(array $options){     
        $id = isset($options['id']) ? $options['id'] : '';
        $htmlAttr = isset($options['htmlAttr']) ? $options['htmlAttr'] : array();
        $content = isset($options['content']) ? $options['content'] : '';
                
        $htmlAttr['id'] = $id;
        $htmlAttr['data-dojo-type'] = $this->getClass();
        
        if(isset($options['dojoAttr'])){        
            $htmlAttr['data-dojo-props'] = $this->dojoAttr($options['dojoAttr']);
        }
        $html = '<' . $this->getRootNode() . $this->_htmlAttribs($htmlAttr) . '>'
            . $content
            . '</'.$this->getRootNode().'>'.self::EOL;        
        return $html;        
    }

    /**    
     * Begin capture of content to be wrapped in dojo module. Options array has the following structure:
     * id: the id of the module
     * htmlAttr: array of strings to be rendered as html attributes
     * dojoAttr: array of strings to be rendered as dojo attributes
     * 
     * @param array $options
     */        
    public function captureStart(array $options)
    {
        $id = isset($options['id']) ? $options['id'] : '';        
        if (isset($this->captureLock[$id])) {
            throw new \Exception(sprintf('Lock already exists for id "%s"', $id));
        }
        $this->captureLock[$id] = true;
        $this->captureInfo[$id] = array();       
        if(isset($options['htmlAttr'])){
            $this->captureInfo[$id]['htmlAttr'] = $options['htmlAttr'];
        }
        if(isset($options['dojoAttr'])){
            $this->captureInfo[$id]['dojoAttr'] = $options['dojoAttr'];
        }
        ob_start();
    }
    
    /**    
     * End capture of content to be wrapped in dojo module.
     * 
     * @param string $id id of the module used when calling captureStart.
     * @return string The renered dojo module
     */      
    public function captureEnd($id)
    {
        if (!isset($this->captureLock[$id])) {
            throw new \Exception(sprintf('No capture lock exists for id "%s"; nothing to capture', $id));
        }
        $renderArgs = array(
            'id' => $id, 
            'content' => ob_get_clean()
        );
        if(isset($this->captureInfo[$id]['htmlAttr'])){
            $renderArgs['htmlAttr'] = $this->captureInfo[$id]['htmlAttr'];
        }
        if(isset($this->captureInfo[$id]['dojoAttr'])){
            $renderArgs['dojoAttr'] = $this->captureInfo[$id]['dojoAttr'];
        }
        unset($this->captureLock[$id], $this->captureInfo[$id]);
        return $this->render($renderArgs);
    }
    
    /**    
     * Render dojo attributes
     * 
     * @param array $dojoAttr array of strings
     * @return string The dojo attributes rendered into a single string
     */      
    protected function dojoAttr($dojoAttr)
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
