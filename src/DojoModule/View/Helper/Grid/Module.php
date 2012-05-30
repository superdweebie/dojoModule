<?php

/** 
 * @package    DojoModule 
 * @license    LGPL 
 */
namespace DojoModule\View\Helper\Grid;

use Zend\View\Helper\Module as BaseModule;
use Zend\Json\Json;

/** 
 *  
 * @since   1.0 
 * @version $Revision$ 
 * @author  Tim Roediger <superdweebie@gmail.com> 
 */
class Module extends BaseModule {
    
    /**    
     * Render the dojo module.
     * Options array has the following structure:
     * id: the id of the module
     * htmlAttr: array of strings to be rendered as html attributes
     * dojoAttr: array of strings to be rendered as dojo attributes
     * structure: array of Column objects that will be rendered as the grid structure
     *      
     * @param array $options
     * @return string The renered dojo module
     */      
    public function render(array $options){     
        $id = isset($options['id']) ? $options['id'] : '';
        $htmlAttr = isset($options['htmlAttr']) ? $options['htmlAttr'] : array();
        $dojoAttr = isset($options['dojoAttr']) ? $options['dojoAttr'] : array();        
        $content = isset($options['content']) ? $options['content'] : '';
        $columns = isset($options['columns']) ? $options['columns'] : array();
        
        $htmlAttr['id'] = $id;
        $htmlAttr['data-dojo-type'] = $this->getClass();
        
        $dojoAttr['structure'] = $this->renderStructure($columns);
        
        if(isset($options['dojoAttr'])){        
            $htmlAttr['data-dojo-props'] = $this->dojoAttr($dojoAttr);
        }
        $html = '<' . $this->getRootNode() . $this->_htmlAttribs($htmlAttr) . '>'
            . $content
            . '</'.$this->getRootNode().'>'.self::EOL;        
        return $html;        
    }
    
    public function renderStructure(array $columns){
        $structure = array();
        foreach ($columns as $column)
        {
            $structure[] = $column->toArray();
        }        
        return str_replace('"', "'", Json::prettyPrint(json_encode($structure)));
    }
}