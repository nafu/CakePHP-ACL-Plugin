<div class="adminUsers view">
<h2><?php  __('Admin User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminUser['AdminUser']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminUser['AdminUser']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminUser['AdminUser']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Admin Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($adminUser['AdminGroup']['name'], array('controller' => 'admin_groups', 'action' => 'view', $adminUser['AdminGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminUser['AdminUser']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adminUser['AdminUser']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Admin User', true), array('action' => 'edit', $adminUser['AdminUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Admin User', true), array('action' => 'delete', $adminUser['AdminUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $adminUser['AdminUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Admin Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Admin Groups', true), array('controller' => 'admin_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin Group', true), array('controller' => 'admin_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
