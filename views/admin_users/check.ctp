<?php
echo $this->element('admin/admin_users/acl/header');
?>

<?php
echo $this->element('admin/admin_users/acl/aros/links');
?>

<?php
if(count($missing_aros['roles']) > 0)
{
	echo '<h3>' . __d('acl', 'Roles without corresponding Aro', true) . '</h3>';

	$list = array();
	foreach($missing_aros['roles'] as $missing_aro)
	{
		$list[] = $missing_aro[$role_model_name][$role_display_field];
	}

	echo $this->Html->nestedList($list);
}
?>

<?php
if(count($missing_aros['users']) > 0)
{
	echo '<h3>' . __d('acl', 'Users without corresponding Aro', true) . '</h3>';

	$list = array();
	foreach($missing_aros['users'] as $missing_aro)
	{
		$list[] = $missing_aro[$user_model_name][$user_display_field];
	}

	echo $this->Html->nestedList($list);
}
?>

<?php
if(count($missing_aros['roles']) > 0 || count($missing_aros['users']) > 0)
{
	echo '<p>';
	echo $this->Html->link(__d('acl', 'Build', true), '/admin/admin_users/check/run');
	echo '</p>';
}
else
{
	echo '<p>';
	echo __d('acl', 'There is no missing ARO.', true);
	echo '</p>';
}
?>

<?php
echo $this->element('admin/admin_users/acl/footer');
?>