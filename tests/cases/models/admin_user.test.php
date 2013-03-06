<?php
App::import('Model', 'Acl.AdminUser');

class AdminUserTestCase extends CakeTestCase {
	var $fixtures = array('plugin.acl.aro', 'plugin.acl.aco', 'plugin.acl.aros_aco', 'plugin.acl.admin_user', 'plugin.acl.admin_group');

	function startTest() {
		$this->AdminUser =& ClassRegistry::init('AdminUser');
	}

	function endTest() {
		unset($this->AdminUser);
		ClassRegistry::flush();
	}

	function testParentNode() {
		$this->AdminUser->id = null;
		$result = $this->AdminUser->parentNode();
		$this->assertNull($result);

		$admin_group_id = 1;
		$this->AdminUser->data = array(
			'AdminUser' => array(
				'id' => 1,
				'username' => 'Lorem ipsum dolor sit amet',
				'password' => 'Lorem ipsum dolor sit amet',
				'admin_group_id' => $admin_group_id
			)
		);
		$result = $this->AdminUser->parentNode();
		$expected = array(
			'AdminGroup' => array(
				'id' => $admin_group_id
			)
		);
		$this->assertEqual($result, $expected);
	}

}
