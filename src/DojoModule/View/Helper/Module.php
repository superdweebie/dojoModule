<?php

namespace DojoModule\View\Helper;

class Module {

    protected $module;
    protected $rootNode;
    protected $stylesheets = array();
    
    public function __construct($name, $rootNode = 'div', array $stylesheets = array()){
        $this->setName($name);
        $this->setRootNode($rootNode);
        $this->setStylesheets($stylesheets);
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
}
