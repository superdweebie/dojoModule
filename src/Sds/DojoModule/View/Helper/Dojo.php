<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\DojoModule\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * View helper for emitting Dojo
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Dojo extends AbstractHelper {

    /**
     * An array of required dojo modules.
     *
     * @var Array
     */
    protected $requires = array();

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
     *
     * @var array
     */
    protected $stylesheets = array();

    /**
     * Sets the dojo theme to use.
     *
     * @param string $theme
     * @return \DojoModule\View\Helper\Dojo
     */
    public function setTheme($theme) {
        $this->theme = (string) $theme;
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
     *
     * @return array
     */
    public function getRequires() {
        return $this->requires;
    }

    /**
     * Sets the array of module aliases that must be emited by the dojo.
     *
     * @param string $requireModules
     * @return \DojoModule\View\Helper\Module
     */
    public function setRequires(array $requires){
        $this->requires = $requires;
    }

    /**
     *
     * @return array
     */
    public function getStylesheets() {
        return $this->stylesheets;
    }

    /**
     *
     * @param array $stylesheets
     */
    public function setStylesheets(array $stylesheets) {
        $this->stylesheets = $stylesheets;
    }

    /**
     * Does nothing.
     *
     * @return \Sds\DojoModule\View\Helper\Module
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

        $renderedRequires = array();
        foreach ($this->requires as $require){
            if (isset($this->stylesheets[$require])){
                foreach ($this->stylesheets[$require] as $stylesheet) {
                    $stylesheet = $this->dojoRoot .'/'. str_replace('[THEME]', $this->theme, $stylesheet);
                    $view->headLink()->appendStylesheet($stylesheet);
                }
            }
            $renderedRequires[] = "'".$require."'";
        }

        $renderedRequires =  implode(',', $renderedRequires);
        $view->headScript()
            ->setAllowArbitraryAttributes(true)
            ->appendFile(
                $this->dojoRoot.'/dojo/dojo.js',
                'text/javascript',
                array('data-dojo-config' => 'async: true, baseUrl: "'.$this->dojoRoot.'/dojo"' )
            )
            ->appendScript("require([$renderedRequires, 'dojo/domReady!'], function(parser) {parser.parse();})"
            );
    }
}