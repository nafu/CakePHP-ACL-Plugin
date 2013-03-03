<div id="aros_link" class="acl_links">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link(__d('acl', 'acl未組み込みユーザーのチェック', true), '/acl/admin_users/check', array('class' => ($selected == 'check' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'ユーザーのグループ確認・変更', true), '/acl/admin_users/users', array('class' => ($selected == 'users' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'グループごとの権限の変更', true), '/acl/admin_users/role_permissions', array('class' => ($selected == 'role_permissions' || $selected == 'ajax_role_permissions' )? 'selected' : null));
//$links[] = $this->Html->link(__d('acl', 'Users permissions', true), '/admin/admin_users/user_permissions', array('class' => ($selected == 'admin_user_permissions' )? 'selected' : null));

echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>