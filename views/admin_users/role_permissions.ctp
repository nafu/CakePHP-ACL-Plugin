<?php
// レイアウトでjqueryが読み込まれない場合は、以下をコメントアウトする。
//echo $this->Html->script('http://static.shareee.jp/js/jquery.js');
echo $this->Html->script('/acl/web/js/admin/admin_users');

echo $this->element('admin/admin_users/acl/header');
?>

<?php
echo $this->element('admin/admin_users/acl/aros/links');
?>

<div class="adminUsers role_permissions">
	<h2><?php __('Admin Users');?></h2>

<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Admin User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Admin Groups', true), array('controller' => 'admin_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin Group', true), array('controller' => 'admin_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div>

	<table border="0" cellpadding="5" cellspacing="2">
	<tr>
    	<?php

    	$column_count = 1;

    	$headers = array(__d('acl', 'controller', true));

    	echo $this->Html->tableHeaders($headers);
    	?>
	</tr>

	<?php

	if (isset($controllers) && is_array($controllers)) {
		foreach ($controllers as $controller_class_name) {

    		echo '<tr class="' . $color . '">
			';

    		echo '<td>' .
			$this->Html->link(__($controller_class_name, true),
			array('action' => 'role_permissions', '?' => array('controller' => $controller_class_name))
			) .
			'</td>';

	    	echo '</tr>
	    	';
		}
	}
	?>
	</table>

	<table border="0" cellpadding="5" cellspacing="2">
	<tr>
    	<?php

    	$column_count = 1;

    	$headers = array(__d('acl', 'action', true));

    	foreach ($roles as $role) {
    	    $headers[] = $role[$role_model_name][$role_display_field];
    	    $column_count++;
    	}

    	echo $this->Html->tableHeaders($headers);
    	?>
	</tr>

	<?php
	$js_init_done = array();
	$previous_ctrl_name = '';
	$i = 0;

	if (isset($actions['app']) && is_array($actions['app'])) {
		foreach ($actions['app'] as $controller_name => $ctrl_infos) {
			if ($previous_ctrl_name != $controller_name) {
				$previous_ctrl_name = $controller_name;

				$color = ($i % 2 == 0) ? 'color1' : 'color2';
			}

			foreach ($ctrl_infos as $ctrl_info) {
	    		echo '<tr class="' . $color . '">
	    		';

	    		echo '<td>' . $controller_name . '->' . $ctrl_info['name'] . '</td>';

		    	foreach ($roles as $role) {
		    	    echo '<td>';
		    	    echo '<span id="right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '">';

		    	   /*
					* The right of the action for the role must still be loaded
    		    	*/
    		        echo $this->Html->image('/acl/web/img/admin/ajax/waiting16.gif', array('title' => __d('acl', 'loading', true)));

    		        if(!in_array($controller_name . '_' . $role[$role_model_name][$role_pk_name], $js_init_done))
    		        {
    		        	$js_init_done[] = $controller_name . '_' . $role[$role_model_name][$role_pk_name];
    		        	$this->Js->buffer('init_register_role_controller("' . $this->Html->url('/', true) . '", "' . $role[$role_model_name][$role_pk_name] . '", "", "' . $controller_name . '", "' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.', true) . '");');
    		        }

		    		echo '</span>';

        	    	echo ' ';
        	    	echo $this->Html->image('/acl/web/img/admin/ajax/waiting16.gif', array('id' => 'right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner', 'style' => 'display:none;'));

        	    	echo '</td>';
		    	}

		    	echo '</tr>
		    	';
			}

			$i++;
		}
	}
	?>
	<?php
	if (isset($actions['plugin']) && is_array($actions['plugin'])) {
	    foreach ($actions['plugin'] as $plugin_name => $plugin_ctrler_infos) {
//    	    debug($plugin_name);
//    	    debug($plugin_ctrler_infos);

    	    $color = null;

    	    echo '<tr class="title"><td colspan="' . $column_count . '">' . __d('acl', 'Plugin', true) . ' ' . $plugin_name . '</td></tr>';

    	    $i = 0;
    	    foreach ($plugin_ctrler_infos as $plugin_ctrler_name => $plugin_methods) {
    	        //debug($plugin_ctrler_name);
    	        //echo '<tr style="background-color:#888888;color:#ffffff;"><td colspan="' . $column_count . '">' . $plugin_ctrler_name . '</td></tr>';

        	    if ($previous_ctrl_name != $plugin_ctrler_name) {
        			$previous_ctrl_name = $plugin_ctrler_name;

        			$color = ($i % 2 == 0) ? 'color1' : 'color2';
        		}


    	        foreach ($plugin_methods as $method) {
    	            echo '<tr class="' . $color . '">
    	            ';

    	            echo '<td>' . $plugin_ctrler_name . '->' . $method['name'] . '</td>';
    	            //debug($method['name']);

        	        foreach ($roles as $role) {
    		    	    echo '<td>';
    		    	    echo '<span id="right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '">';

    		    	    /*
    		    	    * The right of the action for the role must still be loaded
    		    	    */
    		    	    echo $this->Html->image('/acl/web/img/admin/ajax/waiting16.gif', array('title' => __d('acl', 'loading', true)));

	    		    	if (!in_array($plugin_name . "_" . $plugin_ctrler_name . '_' . $role[$role_model_name][$role_pk_name], $js_init_done)) {
	    		        	$js_init_done[] = $plugin_name . "_" . $plugin_ctrler_name . '_' . $role[$role_model_name][$role_pk_name];
	    		        	$this->Js->buffer('init_register_role_controller_toggle_right("' . $this->Html->url('/', true) . '", "' . $role[$role_model_name][$role_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.', true) . '");');
	    		        }

    		    		echo '</span>';

            	    	echo ' ';
            	    	echo $this->Html->image('/acl/web/img/admin/ajax/waiting16.gif', array('id' => 'right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner', 'style' => 'display:none;'));

            	    	echo '</td>';
    		    	}

    	            echo '</tr>
    	            ';
    	        }

    	        $i++;
    	    }
    	}
	}
    ?>
	</table>
	<?php
    echo $this->Html->image('/acl/web/img/admin/acl/tick.png') . ' ' . __d('acl', 'authorized', true);
    echo '&nbsp;&nbsp;&nbsp;';
    echo $this->Html->image('/acl/web/img/admin/acl/cross.png') . ' ' . __d('acl', 'blocked', true);
    ?>

</div>

<?php
echo $this->element('admin/admin_users/acl/footer');
?>