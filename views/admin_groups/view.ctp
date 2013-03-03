<div class="adminGroups view">
<h2><?php  __('Admin Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminGroup['AdminGroup']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminGroup['AdminGroup']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminGroup['AdminGroup']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminGroup['AdminGroup']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Admin Group', true), array('action' => 'edit', $adminGroup['AdminGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Admin Group', true), array('action' => 'delete', $adminGroup['AdminGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $adminGroup['AdminGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Admin Groups', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin Group', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Admin Users', true), array('controller' => 'admin_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin User', true), array('controller' => 'admin_users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Admin Users');?></h3>
	<?php if (!empty($adminGroup['AdminUser'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Password'); ?></th>
		<th><?php __('Admin Group Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($adminGroup['AdminUser'] as $adminUser):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $adminUser['id'];?></td>
			<td><?php echo $adminUser['username'];?></td>
			<td><?php echo $adminUser['password'];?></td>
			<td><?php echo $adminUser['admin_group_id'];?></td>
			<td><?php echo $adminUser['created'];?></td>
			<td><?php echo $adminUser['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'admin_users', 'action' => 'view', $adminUser['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'admin_users', 'action' => 'edit', $adminUser['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'admin_users', 'action' => 'delete', $adminUser['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $adminUser['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Admin User', true), array('controller' => 'admin_users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
