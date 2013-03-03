<?php
echo $this->element('admin/admin_users/acl/header');
?>

<?php
echo $this->element('admin/admin_users/acl/aros/links');
?>

<?php
echo $this->Form->create($user_model_name, array('url' => '/' . $this->params['url']['url']));
echo __d('acl', 'name', true);
echo '<br/>';
echo $this->Form->input($user_display_field, array('label' => false, 'div' => false));
echo ' ';
echo $this->Form->end(array('label' =>__d('acl', 'filter', true), 'div' => false));
echo '<br/>';
?>
<table border="0" cellpadding="5" cellspacing="2">
<tr>
	<?php
$column_count = 1;

$headers = array($paginator->sort(__d('acl', 'name', true), $user_display_field));

foreach($roles as $role)
{
	$headers[] = $role[$role_model_name][$role_display_field];
	$column_count++;
}

echo $this->Html->tableHeaders($headers);

?>

</tr>
<?php
foreach($users as $user)
{
	$style = isset($user['Aro']) ? '' : ' class="line_warning"';

	echo '<tr' . $style . '>';
	echo '  <td>' . $user[$user_model_name][$user_display_field] . '</td>';

	foreach($roles as $role)
	{
		if(isset($user['Aro']) && $role[$role_model_name][$role_pk_name] == $user[$user_model_name][$role_fk_name])
		{
			echo '  <td>' . $this->Html->image('/acl/web/img/admin/acl/tick.png') . '</td>';
		}
		else
		{
			$title = __d('acl', 'Update the user role', true);
			echo '  <td>' . $this->Html->link($this->Html->image('/acl/web/img/admin/acl/tick_disabled.png'), '/acl/admin_users/update_user_role/?user=' . $user[$user_model_name][$user_pk_name] . '&role=' . $role[$role_model_name][$role_pk_name], array('title' => $title, 'alt' => $title, 'escape' => false)) . '</td>';
		}
	}

	//echo '  <td>' . (isset($user['Aro']) ? $this->Html->image('/acl/web/img/admin/acl/tick.png') : $this->Html->image('/acl/web/img/admin/acl/cross.png')) . '</td>';

	echo '</tr>';
}
?>
<tr>
	<td class="paging" colspan="<?php echo $column_count ?>">
		<?php echo $paginator->numbers(); ?>
	</td>
</tr>
</table>


<?php
if($missing_aro)
{
?>
    <div style="margin-top:20px">

    <p class="warning"><?php echo __d('acl', 'Some users AROS are missing. Click on a role to assign one to a user.', true) ?></p>

    </div>
<?php
}
?>

<?php
echo $this->element('admin/admin_users/acl/footer');
?>