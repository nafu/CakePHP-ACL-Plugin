<div id="acos_link" class="acl_links">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link(__d('acl', 'acl未対応のアクションをaclに対応させる', true), '/acl/admin_users/build_acl', array('class' => ($selected == 'build_acl' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'acl対応のアクションの情報を削除する', true), '/acl/admin_users/empty_acos', array(array('confirm' => __d('acl', 'are you sure ?', true)), 'class' => ($selected == 'empty_acos' )? 'selected' : null));

echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>