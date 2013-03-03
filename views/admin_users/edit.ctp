<div class="adminUsers form">
<?php echo $this->Form->create('AdminUser');?>
	<fieldset>
		<legend><?php __('Edit Admin User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('admin_group_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('AdminUser.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('AdminUser.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Admin Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Admin Groups', true), array('controller' => 'admin_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin Group', true), array('controller' => 'admin_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>