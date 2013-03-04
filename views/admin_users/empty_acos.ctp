<?php
echo $this->element('admin/admin_users/acl/header');
?>

<?php
echo $this->element('admin/admin_users/acl/acos/links');
?>

<?php

echo '<p>';
echo __d('acl', 'This page allows you to clear all actions ACOs.', true);
echo '</p>';

echo '<p>';
echo __d('acl', 'Clicking the link will destroy all existing actions ACOs and associated permissions.', true);
echo '</p>';

echo '<p>';
echo $this->Html->link($this->Html->image('/acl/web/img/admin/acl/cross.png') . ' ' . __d('acl', 'Clear ACOs', true), '/acl/admin_users/empty_acos/run', array('confirm' => __d('acl', 'Are you sure you want to destroy all existing ACOs ?', true), 'escape' => false));
echo '</p>';
?>

<?php
echo $this->element('admin/admin_users/acl/footer');
?>