<div class="adminGroups form">
<?php echo $this->Form->create('AdminGroup');?>
	<fieldset>
		<legend><?php __('Edit Admin Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('AdminGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('AdminGroup.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Admin Groups', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Admin Users', true), array('controller' => 'admin_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin User', true), array('controller' => 'admin_users', 'action' => 'add')); ?> </li>
	</ul>
</div>