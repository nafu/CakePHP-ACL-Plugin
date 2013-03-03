<?php
echo $this->element('admin/admin_users/acl/header');
?>

<?php
if($run)
{
	echo '<p>';
	echo __d('init DB', 'Great initialize Success!!!', true);
	echo '</p>';
}
else
{

	echo '<p>';
	echo __d('init DB', 'Clicking the link will initialize aros_acos table.', true);
	echo '</p>';

	echo '<p>';
	echo $this->Html->link('init DB', '/admin/admin_users/init_db/run', array('confirm' => __d('init DB', 'Are you sure you want to initialize DB?', true), 'escape' => false));
	echo '</p>';
}
?>

<?php
echo $this->element('admin/admin_users/acl/footer');
?>