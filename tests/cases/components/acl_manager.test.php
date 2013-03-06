<?php
/* AclManager Test cases generated on: 2013-03-04 05:18:18 : 1362341898*/
App::import('Component', 'Acl.AclManager');
App::import('Model', 'Acl.AdminUser');
App::import('Model', 'Acl.AdminGroup');

class FakeAclManagerController {}

class AclManagerComponentTestCase extends CakeTestCase {
	var $fixtures = array('plugin.acl.aro', 'plugin.acl.aco', 'plugin.acl.aros_aco', 'plugin.acl.admin_user', 'plugin.acl.admin_group');
	function startTest() {
		$this->AclManager =& new AclManagerComponent();
		$controller = new FakeAclManagerController();
		//$controller->AclReflector = new FakeAclManagerTest();
		$this->AclManager->initialize(&$controller);
	}

	function endTest() {
		unset($this->AclManager);
		ClassRegistry::flush();
	}

	function testCheckUserModelActsAsAclRequester() {
		$result = $this->AclManager->checkUserModelActsAsAclRequester('Aco');
		$this->assertFalse($result);
		$result = $this->AclManager->checkUserModelActsAsAclRequester('AdminUser');
		$this->assertTrue($result);
		$result = $this->AclManager->checkUserModelActsAsAclRequester('AdminGroup');
		$this->assertTrue($result);
	}

	function testGetStoredControllersHashes() {

	}

	function testGetCurrentControllersHashes() {

	}

	function testGetMissingAcos() {

	}

	function testCreateAcos() {

	}

	function testSavePermission() {

	}

}
