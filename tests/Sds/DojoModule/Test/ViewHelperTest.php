<?php

namespace Sds\DojoModule\Test\Model;

use Sds\ModuleUnitTester\AbstractTest;
use Zend\View\Renderer\PhpRenderer;

class ViewHelperTest extends AbstractTest{

    public function setUp(){
        parent::setUp();
    }

    protected function alterConfig(array $config) {
        return $config;
    }

    public function testViewHelperPersist(){

        $view = new PhpRenderer();
        $view->setHelperPluginManager($this->serviceManager->get('ViewHelperManager'));
        
        $view->dojo()->activate();

        $headLink = $view->headLink();

        $this->assertEquals('js/dojo_rel/dojo/resources/dojo.css', $headLink[0]->href);
        $this->assertEquals('screen', $headLink[0]->media);
        $this->assertEquals('stylesheet', $headLink[0]->rel);
        $this->assertEquals('text/css', $headLink[0]->type);

        $this->assertEquals('js/dojo_rel/dijit/themes/claro/claro.css', $headLink[1]->href);
        $this->assertEquals('screen', $headLink[1]->media);
        $this->assertEquals('stylesheet', $headLink[1]->rel);
        $this->assertEquals('text/css', $headLink[1]->type);

        $headScript = $view->headScript();

        $this->assertEquals('async: true, baseUrl: "js/dojo_rel/dojo"', $headScript[0]->attributes['data-dojo-config']);
        $this->assertEquals('js/dojo_rel/dojo/dojo.js', $headScript[0]->attributes['src']);
        $this->assertEquals('text/javascript', $headScript[0]->type);

        $this->assertEquals(
            "require(['dojo/parser', 'dojo/domReady!'], function(parser) {parser.parse();})",
            $headScript[1]->source
        );
        $this->assertEquals('text/javascript', $headScript[1]->type);

        $this->assertEquals('claro', $view->dojo()->getTheme());
    }
}

