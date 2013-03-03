<?php 
echo $this->element('admin/admin_users/acl/header');
?>

<?php 
echo $this->element('admin/admin_users/acl/acos/links');
?>

<?php
if($run)
{
    if(count($logs) > 0)
    {
        echo '<p>';
        echo __d('acl', 'The following actions ACOs have been created', true);
        echo '<p>';
        echo $this->Html->nestedList($logs);
    }
    else
    {
        echo '<p>';
        echo __d('acl', 'There was no new actions ACOs to create', true);
        echo '</p>';
    }
}
else
{
    echo '<p>';
    echo __d('acl', 'This page allows you to build missing actions ACOs if any.', true);
    echo '</p>';
    
    echo '<p>';
    echo __d('acl', 'Clicking the link will not destroy existing actions ACOs.', true);
    echo '</p>';
    
    echo '<p>';
    echo $this->Html->link(__d('acl', 'Build', true), '/admin/admin_users/build_acl/run');
    echo '</p>';
}
?>

<?php
echo $this->element('admin/admin_users/acl/footer');
?>