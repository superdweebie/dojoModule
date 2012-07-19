<?php

namespace Sds\DojoModule\Test;

use Sds\DojoModule\Tools\ProfileGenerator;
use Sds\ModuleUnitTester\AbstractTest;

class ProfileGeneratorTest extends AbstractTest{

    protected $profilePath = 'vendor/superdweebie/dojo-module/tests/buildProfile';

    public function setUp(){
        parent::setUp();
    }

    protected function alterConfig(array $config) {
        $config['sds']['dojo']['build']['profilePath'] = $this->profilePath . '/generated.profile.js';
        return $config;
    }

    public function testViewHelperPersist(){

        $config = $this->serviceManager->get('Configuration')['sds']['dojo'];
        ProfileGenerator::generate($config);

        $this->assertEquals(
            file_get_contents($this->profilePath . '/desired.profile.js'),
            file_get_contents($this->profilePath . '/generated.profile.js')
        );
    }
}

