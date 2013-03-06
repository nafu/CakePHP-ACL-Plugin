<?php
/* AdminGroup Test cases generated on: 2013-03-04 03:55:50 : 1362336950*/
App::import('Model', 'Acl.AdminGroup');

class AdminGroupTestCase extends CakeTestCase {
	var $fixtures = array('plugin.acl.aro', 'plugin.acl.aco', 'plugin.acl.aros_aco', 'plugin.acl.admin_user', 'plugin.acl.admin_group');

	function startTest() {
		$this->AdminGroup =& ClassRegistry::init('AdminGroup');
	}

	function endTest() {
		unset($this->AdminGroup);
		ClassRegistry::flush();
	}

	function testParentNode() {
		$result = $this->AdminGroup->parentNode();
		$this->assertNull($result);
	}

}
