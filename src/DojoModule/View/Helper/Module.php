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
     * @param string $name
     * @return \DojoModule\View\Helper\Module
     */   
    public function __construct($name){
        $this->setName($name);
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getRootNode() {
        return $this->rootNode;
    }

    public function setRootNode($rootNode) {
        $this->rootNode = $rootNode;
        return $this;
    }    

    public function getStylesheets() {
        return $this->stylesheets;
    }

    public function setStylesheets($stylesheets) {
        $this->stylesheets = $stylesheets;
        return $this;
    } 
    
    public function render(array $options){     
        $id = isset($options['id']) ? $options['id'] : '';
        $htmlAttr = isset($options['htmlAttr']) ? $options['htmlAttr'] : array();
        $content = isset($options['content']) ? $options['content'] : '';
                
        $htmlAttr['id'] = $id;
        $htmlAttr['data-dojo-type'] = $this->getName();
        
        if(isset($options['dojoAttr'])){        
            $htmlAttr['data-dojo-props'] = $this->_dojoAttr($options['dojoAttr']);
        }
        $html = '<' . $this->getRootNode() . $this->_htmlAttribs($htmlAttr) . '>'
            . $content
            . '</'.$this->getRootNode().'>'.self::EOL;        
        return $html;        
    }

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
        return;
    }
    
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
