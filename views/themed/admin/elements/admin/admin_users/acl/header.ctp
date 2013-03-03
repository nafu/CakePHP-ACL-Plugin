<?php
echo $this->Html->css('/web/css/admin/admin_users.css');
?>
<div id="plugin_acl">

	<?php
	echo $this->Session->flash('acl');
	?>

	<h1><?php echo __d('acl', 'ACL', true); ?></h1>

	<?php

	if(!isset($no_acl_links))
	{
	    $selected = isset($selected) ? $selected : $this->params['action'];

        $links = array();
        $links[] = $this->Html->link(__d('acl', '権限の変更', true), '/admin/admin_users/aros_index', array('class' => ($selected == 'aros_index' || $selected == 'check' || $selected == 'users' || $selected == 'role_permissions' )? 'selected' : null));
        $links[] = $this->Html->link(__d('acl', 'アクションのチェック', true), '/admin/admin_users/acos_index', array('class' => ($selected == 'acos_index' || $selected == 'build_acl' || $selected == 'empty_acos' )? 'selected' : null));

		$links[] = $this->Html->link(__d('acl', 'データベースの初期化', true), '/admin/admin_users/init_db', array('class' => ($selected == 'init_db')? 'selected' : null));

        echo $this->Html->nestedList($links, array('class' => 'acl_links'));
	}
	?>