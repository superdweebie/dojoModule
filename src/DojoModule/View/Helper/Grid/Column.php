<?php

/** 
 * @package    DojoModule 
 * @license    LGPL 
 */
namespace DojoModule\View\Helper\Grid;

class Column
{
    protected $_field;
    protected $_name;
    protected $_width = 10;
    protected $_editable = false;
    protected $_cellType = null;
    protected $_formatter = null;
    protected $_datatype = null;
    protected $_hidden = false;
    
    public function __construct(array $options)
    {
        $this->_field = isset($options['field']) ? $options['field'] : $this->_field;
        $this->_name = isset($options['name']) ? $options['name'] : $this->_name;
        $this->_width = isset($options['width']) ? $options['width'] : $this->_width;
        $this->_editable = isset($options['editable']) ? $options['editable'] : $this->_editable;
        if (isset($options['cellType']))
        {
            switch ($options['cellType']){
                case 'boolean':
                    $this->_cellType = 'dojox.grid.cells.Bool';
                    break;
            }
        }
        $this->_formatter = isset($options['formatter']) ? $options['formatter'] : $this->_formatter;
        $this->_datatype = isset($options['datatype']) ? $options['datatype'] : $this->_datatype;
        $this->_hidden = isset($options['hidden']) ? $options['hidden'] : $this->_hidden;        
    }

    public function getFormatter()
    {
        return $this->_formatter;
    }

    public function hasFormatter()
    {
        return isset($this->_formatter);
    }

    public function toArray()
    {
        $result = array();
        if (isset($this->_field))
        {
            $result['field'] = $this->_field;
        }
        if (isset($this->_name))
        {
            $result['name'] = $this->_name;
        }
        if (isset($this->_width))
        {
            $result['width'] = $this->_width;
        }
        if (isset($this->_editable))
        {
            $result['editable'] = $this->_editable;
        }
        if (isset($this->_cellType))
        {
            $result['cellType'] = $this->_cellType;
        }
        if (isset($this->_formatter))
        {
            $result['formatter'] = $this->_formatter;
        }
        if (isset($this->_datatype))
        {
            $result['datatype'] = $this->_datatype;
        }
        if (isset($this->_hidden))
        {
            $result['hidden'] = $this->_hidden;
        }        
        return $result;
    }
}
