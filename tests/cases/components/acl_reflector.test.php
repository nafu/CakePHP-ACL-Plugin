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

	function testGetControllerClassname() {
		$result = $this->AclReflector->getControllerClassname('AclController');
		$expected = 'AclController';
		$this->assertEqual($result, $expected);

		$result = $this->AclReflector->getControllerClassname('Acl');
		$expected = 'AclController';
		$this->assertEqual($result, $expected);
	}

	function testGetAllPluginsPaths() {
		$result = $this->AclReflector->getAllPluginsPaths();
	}

	function testGetAllPluginsNames() {
		$result = $this->AclReflector->getAllPluginsNames();
	}

	function testGetAllPluginsControllers() {
		$result = $this->AclReflector->getAllPluginsControllers();
	}

	function testgetAllPluginsControllersActions() {
		$result = $this->AclReflector->getAllPluginsControllersActions();
	}

	function testGetAllAppControllers() {
		$result = $this->AclReflector->getAllAppControllers();
	}

	function testGetAllAppControllersActions() {
		$result = $this->AclReflector->getAllAppControllersActions();
	}

	function testGetAllControllers() {
		$result = $this->AclReflector->getAllControllers();
	}

	function testGetAllActions() {
		$result = $this->AclReflector->getAllActions();
	}

	function testGetControllerActions() {
		$result = $this->AclReflector->getControllerActions('');
	}

}
