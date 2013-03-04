<?php
/* AclReflector Test cases generated on: 2013-03-04 05:18:26 : 1362341906*/
App::import('Component', 'Acl.AclReflector');

class FakeAclReflectorController {}

class AclReflectorComponentTestCase extends CakeTestCase {
	function startTest() {
		$this->AclReflector =& new AclReflectorComponent();
		$controller = new FakeAclReflectorController();
        //$controller->AclReflector = new FakeAclReflectorTest();
        $this->AclReflector->initialize(&$controller);
	}

	function endTest() {
		unset($this->AclReflector);
		ClassRegistry::flush();
	}

	function testGetPluginName() {
		$result = $this->AclReflector->getPluginName('acl/admin_users');
		$expected = 'acl';
		$this->assertEqual($result, $expected);

		$result = $this->AclReflector->getPluginName('acl');
		$this->assertFalse($result);

		$result = $this->AclReflector->getPluginName();
		$this->assertFalse($result);
	}

	function testGetPluginControllerName() {
		$result = $this->AclReflector->getPluginControllerName('acl/admin_users');
		$expected = 'admin_users';
		$this->assertEqual($result, $expected);

		$result = $this->AclReflector->getPluginControllerName('admin_users');
		$this->assertFalse($result);

		$result = $this->AclReflector->getPluginControllerName();
		$this->assertFalse($result);
	}

}
