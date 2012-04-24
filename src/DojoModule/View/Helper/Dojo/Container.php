<?php
/**
 * @package    DojoModule
 * @copyright  Copyright (c) 2012 Tim Roediger
 * @license    LGPL
 */
namespace DojoModule\View\Helper\Dojo;

use DojoModule\View\Helper\Dojo\Element;

abstract class Container extends Element
{
    /**
     * Capture locks
     * @var array
     */
    protected $_captureLock = array();

    /**
     * Metadata information to use with captured content
     * @var array
     */
    protected $_captureInfo = array();

    public function __invoke(array $options = array())
    {
        return $this;
    }    
    
    /**
     * Begin capturing content for layout container
     *
     * @param  string $id
     * @param  array $params
     * @param  array $attribs
     * @return void
     */
    public function captureStart(array $options = array())
    {
        $id = array_key_exists('id', $options) ? $options['id'] : array();        
        $htmlAttr = array_key_exists('htmlAttr', $options) ? $options['htmlAttr'] : array();
        $dojoAttr = array_key_exists('dojoAttr', $options) ? $options['dojoAttr'] : array();        
        
        if (array_key_exists($id, $this->_captureLock)) {
            require_once 'Zend/Dojo/View/Exception.php';
            throw new Zend_Dojo_View_Exception(sprintf('Lock already exists for id "%s"', $id));
        }

        $this->_captureLock[$id] = true;
        $this->_captureInfo[$id] = array(
            'htmlAttr'  => $htmlAttr,
            'dojoAttr' => $dojoAttr
        );

        ob_start();
        return;
    }

    /**
     * Finish capturing content for layout container
     *
     * @param  string $id
     * @return string
     */
    public function captureEnd($id)
    {
        if (!array_key_exists($id, $this->_captureLock)) {
            require_once 'Zend/Dojo/View/Exception.php';
            throw new Zend_Dojo_View_Exception(sprintf('No capture lock exists for id "%s"; nothing to capture', $id));
        }
        $content = ob_get_clean();
        $htmlAttr = $this->_captureInfo[$id]['htmlAttr'];
        $dojoAttr = $this->_captureInfo[$id]['dojoAttr'];        
        unset($this->_captureLock[$id], $this->_captureInfo[$id]);
        return parent::__invoke(array('id' => $id, 'htmlAttr' => $htmlAttr, 'dojoAttr' => $dojoAttr, 'content' => $content));
    }
}