<?php

namespace DojoModule\View\Helper;

use Zend\View\Helper\HtmlElement;

class Module extends HtmlElement {

    protected $module;
    protected $rootNode = 'div';
    protected $stylesheets = array();
    
    protected $captureLock = array();
    protected $captureInfo = array();
    
    public function __construct($name){
        $this->setName($name);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getRootNode() {
        return $this->rootNode;
    }

    public function setRootNode($rootNode) {
        $this->rootNode = $rootNode;
    }    
    public function getStylesheets() {
        return $this->stylesheets;
    }

    public function setStylesheets($stylesheets) {
        $this->stylesheets = $stylesheets;
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
