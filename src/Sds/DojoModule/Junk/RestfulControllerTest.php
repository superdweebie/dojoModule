<?php

namespace Sds\ModuleUnitTester\BaseTest;

use Sds\DoctrineExtensionsModule\Service\RestfulControllerFactory;
use Sds\ModuleUnitTester\AbstractTest;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\Parameters;

class RestfulControllerTest extends AbstractTest{

    const DEFAULT_DB = 'doctrineExtensionsModuleTest';

    protected $controller;

    protected $documentManager;

    public function setUp(){
        parent::setUp();

        $factory = new RestfulControllerFactory('restfulControllerTest');
        $this->controller = $factory->createService($this->serviceManager);
        $this->documentManager = $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    protected function alterConfig(array $config) {
        $config['restfulControllerTest'] = array(
            'documentClass' => 'Sds\DoctrineExtensionsModule\Test\TestAsset\Document\User',
            'documentManager' => 'odm_default',
            'serializer' => 'sds.doctrineExtensions.serializer',
            'validator' => 'sds.doctrineExtensions.validator',
        );

        $config['doctrine']['configuration']['odm_default']['default_db'] = self::DEFAULT_DB;

        $config['doctrine']['driver']['odm_default']['drivers']['Sds\DoctrineExtensionsModule\Test\TestAsset\Document'] = 'testAsset';
        $config['doctrine']['driver']['testAsset'] = array(
            'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
            'paths' => array(__DIR__ . '/TestAsset/Document')
        );
        return $config;
    }

    public function testCreate(){

        $userArray = array(
            'className' => 'Sds\DoctrineExtensionsModule\Test\TestAsset\Document\User',
            'id' => 'superdweebie',
            'location' => 'here',
            'groups' => array(
                array('name' => 'groupA'),
                array('name' => 'groupB'),
            ),
            'password' => 'secret',
            'profile' => array(
                'firstname' => 'Tim',
                'lastname' => 'Roediger'
            ),
        );

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setPost(new Parameters($userArray));

        $event = new MvcEvent();
        $event->setRouteMatch(new RouteMatch(array()));
        $event->setApplication($this->serviceManager->get('application'));

        $response = null;
        $this->controller->setEvent($event);
        $consoleModel = $this->controller->dispatch($request, $response);

        $id = $consoleModel->getResult();

        $repository = $this->documentManager->getRepository('Sds\DoctrineExtensionsModule\Test\TestAsset\Document\User');
        $this->documentManager->clear();
        $user = $repository->find($id);

        $this->assertEquals('superdweebie', $user->getId());
        $this->assertEquals('here', $user->location());
        $this->assertEquals('groupA', $user->getGroups()[0]);
        $this->assertEquals('Tim', $user->getProfile()->getFirstName());
    }

    public function testUpdate(){

        $userArray = array(
            'location' => 'there',
            'groups' => array(
                array('name' => 'groupB'),
            ),
            'profile' => array(
                'firstname' => 'Toby'
            ),
        );

        $request = new Request();
        $request->setMethod(Request::METHOD_PUT);
        $request->setQuery(new Parameters(array('id' => 'superdweebie')));
        $request->setContent($userArray);

        $event = new MvcEvent();
        $event->setRouteMatch(new RouteMatch(array()));
        $event->setApplication($this->serviceManager->get('application'));

        $response = null;
        $this->controller->setEvent($event);
        $consoleModel = $this->controller->dispatch($request, $response);

        $repository = $this->documentManager->getRepository('Sds\DoctrineExtensionsModule\Test\TestAsset\Document\User');
        $this->documentManager->clear();
        $user = $repository->find($this->id);

        $this->assertEquals('superdweebie', $user->getId());
        $this->assertEquals('there', $user->location());
        $this->assertEquals('groupB', $user->getGroups()[0]);
        $this->assertEquals('Toby', $user->getProfile()->getFirstName());
    }
}
