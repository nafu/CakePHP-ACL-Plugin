<div class="adminUsers index">
	<h2><?php __('Admin Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('username');?></th>
			<th><?php echo $this->Paginator->sort('password');?></th>
			<th><?php echo $this->Paginator->sort('admin_group_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
<?php
$i = 0;
foreach ($adminUsers as $adminUser):
	$class = null;
if ($i++ % 2 == 0) {
	$class = ' class="altrow"';
}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $adminUser['AdminUser']['id']; ?>&nbsp;</td>
		<td><?php echo $adminUser['AdminUser']['username']; ?>&nbsp;</td>
		<td><?php echo $adminUser['AdminUser']['password']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($adminUser['AdminGroup']['name'], array('controller' => 'admin_groups', 'action' => 'view', $adminUser['AdminGroup']['id'])); ?>
		</td>
		<td><?php echo $adminUser['AdminUser']['created']; ?>&nbsp;</td>
		<td><?php echo $adminUser['AdminUser']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $adminUser['AdminUser']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $adminUser['AdminUser']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $adminUser['AdminUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $adminUser['AdminUser']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>
	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Admin User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Admin Groups', true), array('controller' => 'admin_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin Group', true), array('controller' => 'admin_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>