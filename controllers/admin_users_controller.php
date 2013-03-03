<?php
class AdminUsersController extends AclAppController {
	var $name = 'AdminUsers';
	var $uses = array('Acl.AdminUser', 'Acl.AdminGroup', 'Aco', 'Aro');
	var $autoRender = true;
	var $layout = 'admins';
	var $components = array('Acl', 'Auth', 'Session', 'Acl.AclReflector', 'Acl.AclManager', 'RequestHandler');
	var $helpers = array('Js' => array('Jquery'));

	/**
	 * themeの設定
	 */
	var $theme = 'admin';

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'logout');
		$this->set('title_for_layout', 'ACL管理画面');
		//常に実行できるアクションの設定
		//$this->Auth->allowedActions = array('');
	}

	//権限初期化
	function init_db($run = null) {
		if (isset($run)) {
			$this->set('run', true);
			$group =& $this->AdminUser->AdminGroup;
			$group = new AdminGroup();

			//管理者グループにはすべてを許可する
			$group->id = 1;
			$this->Acl->allow($group, 'controllers');

			//マネージャグループにはAdminUsersのadd, index, logoutに対するアクセスを許可する
			$group->id = 2;
			$this->Acl->deny($group, 'controllers');
			$this->Acl->allow($group, 'controllers/AdminUsers/add');
			$this->Acl->allow($group, 'controllers/AdminUsers/index');
			$this->Acl->allow($group, 'controllers/AdminUsers/logout');

			//ユーザグループにはAdminUsersのindex, logoutに対するアクセスを許可する
			$group->id = 3;
			$this->Acl->deny($group, 'controllers');
			$this->Acl->allow($group, 'controllers/AdminUsers/index');
			$this->Acl->allow($group, 'controllers/AdminUsers/logout');
		} else {
			$this->set('run', false);
		}
	}

	/**
	 * login
	 */
	public function login() {
	}

	public function logout() {
		if ($this->Auth->logout()) {
			$this->redirect('/admin_users/login');
		}
	}

	function index() {
		$this->AdminUser->recursive = 0;
		$this->set('adminUsers', $this->paginate());
	}

	function aros_index() {
	}

	function check($run = null) {
		$user_model_name = Configure::read('acl.aro.user.model');
		$role_model_name = Configure::read('acl.aro.role.model');

		$user_display_field = $this->AclManager->set_display_name($user_model_name, Configure::read('acl.user.display_name'));
		$role_display_field = $this->AclManager->set_display_name($role_model_name, Configure::read('acl.aro.role.display_field'));

		$this->set('user_display_field', $user_display_field);
		$this->set('role_display_field', $role_display_field);

		$roles = $this->{$role_model_name}->find('all', array(
				'order' => $role_display_field,
				'contain' => false,
				'recursive' => -1
			));

		$missing_aros = array(
			'roles' => array(),
			'users' => array()
		);

		foreach ($roles as $role) {
			/*
       * Check if ARO for role exist
       */
			$aro = $this->Aro->find('first', array(
					'conditions' => array(
						'model' => $role_model_name,
						'foreign_key' => $role[$role_model_name][$this->_get_role_primary_key_name()]
					)
				));

			if ($aro === false) {
				$missing_aros['roles'][] = $role;
			}
		}

		$users = $this->{$user_model_name}->find('all', array(
				'order' => $user_display_field,
				'contain' => false,
				'recursive' => -1
			));
		foreach ($users as $user) {
			/*
       * Check if ARO for user exist
       */
			$aro = $this->Aro->find('first', array(
					'conditions' => array(
						'model' => $user_model_name,
						'foreign_key' => $user[$user_model_name][$this->_get_user_primary_key_name()]
					)
				));

			if ($aro === false) {
				$missing_aros['users'][] = $user;
			}
		}


		if (isset($run)) {
			$this->set('run', true);

			/*
       * Complete roles AROs
       */
			if (count($missing_aros['roles']) > 0) {
				foreach ($missing_aros['roles'] as $k => $role) {
					$this->Aro->create(array(
							'parent_id' => null,
							'model' => $role_model_name,
							'foreign_key' => $role[$role_model_name][$this->_get_role_primary_key_name()],
							'alias' => $role[$role_model_name][$role_display_field]
						));

					if ($this->Aro->save()) {
						unset($missing_aros['roles'][$k]);
					}
				}
			}

			/*
       * Complete users AROs
       */
			if (count($missing_aros['users']) > 0) {
				foreach ($missing_aros['users'] as $k => $user) {
					/*
           * Find ARO parent for user ARO
           */
					$parent_id = $this->Aro->field('id', array(
							'model' => $role_model_name,
							'foreign_key' => $user[$user_model_name][$this->_get_role_foreign_key_name()]
						));

					if ($parent_id !== false) {
						$this->Aro->create(array(
								'parent_id' => $parent_id,
								'model' => $user_model_name,
								'foreign_key' => $user[$user_model_name][$this->_get_user_primary_key_name()],
								'alias' => $user[$user_model_name][$user_display_field]
							));

						if ($this->Aro->save()) {
							unset($missing_aros['users'][$k]);
						}
					}
				}
			}
		} else {
			$this->set('run', false);
		}

		$this->set('missing_aros', $missing_aros);

	}

	function users() {
		$user_model_name = Configure::read('acl.aro.user.model');
		$role_model_name = Configure::read('acl.aro.role.model');

		$user_display_field = $this->AclManager->set_display_name($user_model_name, Configure::read('acl.user.display_name'));
		$role_display_field = $this->AclManager->set_display_name($role_model_name, Configure::read('acl.aro.role.display_field'));

		$this->paginate['order'] = array(
			$user_display_field => 'asc'
		);

		$this->set('user_display_field', $user_display_field);
		$this->set('role_display_field', $role_display_field);

		$this->{$role_model_name}->recursive = -1;
		$roles                               = $this->{$role_model_name}->find('all', array(
				'order' => $role_display_field,
				'contain' => false,
				'recursive' => -1
			));

		$this->{$user_model_name}->recursive = -1;

		if (isset($this->data[$user_model_name][$user_display_field]) || $this->Session->check('acl.aros.users.filter')) {
			if (!isset($this->data[$user_model_name][$user_display_field])) {
				$this->data[$user_model_name][$user_display_field] = $this->Session->read('acl.aros.users.filter');
			} else {
				$this->Session->write('acl.aros.users.filter', $this->data[$user_model_name][$user_display_field]);
			}

			$filter = array(
				$user_model_name . '.' . $user_display_field . ' LIKE' => '%' . $this->data[$user_model_name][$user_display_field] . '%'
			);
		} else {
			$filter = array();
		}

		$users = $this->paginate($user_model_name, $filter);

		$missing_aro = false;

		foreach ($users as &$user) {
			$aro = $this->Acl->Aro->find('first', array(
					'conditions' => array(
						'model' => $user_model_name,
						'foreign_key' => $user[$user_model_name][$this->_get_user_primary_key_name()]
					)
				));

			if ($aro !== false) {
				$user['Aro'] = $aro['Aro'];
			} else {
				$missing_aro = true;
			}
		}

		$this->set('roles', $roles);
		$this->set('users', $users);
		$this->set('missing_aro', $missing_aro);
	}

	function update_user_role() {
		$user_model_name = Configure::read('acl.aro.user.model');

		$data = array(
			$user_model_name => array(
				$this->_get_user_primary_key_name() => $this->params['url']['user'],
				$this->_get_role_foreign_key_name() => $this->params['url']['role']
			)
		);

		if ($this->{$user_model_name}->save($data)) {
			$this->Session->setFlash(__d('acl', 'The user role has been updated', true), 'flash_message', null, 'plugin_acl');
		} else {
			$errors = array_merge(array(
					__d('acl', 'The user role could not be updated', true)
				), $this->{$user_model_name}->validationErrors);
			$this->Session->setFlash($errors, 'flash_error', null, 'plugin_acl');
		}

		$this->_return_to_referer();
	}

	function grant_role_permission() {
		//?role_id=3&plugin=&controller=AdminUsers
		$role =& $this->{Configure::read('acl.aro.role.model')};

		$role_id   = $this->params['url']['role_id'];
		$role_data = $role->read(null, $role_id);
		$aco_path  = $this->_get_passed_aco_path();
		/*
     * Check if the role exists in the ARO table
     */
		$aro_node  = $this->Acl->Aro->node($role_data);
		if (!empty($aro_node)) {
			if (!$this->AclManager->save_permission($aro_node, $aco_path, 'grant')) {
				$this->set('acl_error', true);
			}
		} else {
			$this->set('acl_error', true);
			$this->set('acl_error_aro', true);
		}

		$this->set('role_id', $role_id);
		$this->_set_aco_variables();

		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax_role_granted');
		} else {
			$this->_return_to_referer();
		}
	}

	function deny_role_permission() {
		//?role_id=3&plugin=&controller=AdminUsers
		$role =& $this->{Configure::read('acl.aro.role.model')};

		$role_id   = $this->params['url']['role_id'];
		$role_data = $role->read(null, $role_id);
		$aco_path  = $this->_get_passed_aco_path();
		$aro_node  = $this->Acl->Aro->node($role_data);
		if (!empty($aro_node)) {
			if (!$this->AclManager->save_permission($aro_node, $aco_path, 'deny')) {
				$this->set('acl_error', true);
			}
		} else {
			$this->set('acl_error', true);
		}

		$this->set('role_id', $role_id);
		$this->_set_aco_variables();

		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax_role_denied');
		} else {
			$this->_return_to_referer();
		}
	}

	function acos_index() {
	}

	function build_acl($run = null) {
		if (isset($run)) {
			$logs = $this->AclManager->create_acos();

			$this->set('logs', $logs);
			$this->set('run', true);
		} else {
			$this->set('run', false);
		}
	}

	function empty_acos($run = null) {
		if (isset($run)) {
			if ($this->Aco->deleteAll(array(
						'id > 0'
					))) {
				$this->Session->setFlash(__d('acl', 'The ACO table has been cleared', true), 'flash_message', null, 'acl');
			} else {
				$this->Session->setFlash(__d('acl', 'The ACO table could not be cleared', true), 'flash_error', null, 'acl');
			}

			$this->set('run', true);
		} else {
			$this->set('run', false);
		}
	}

	function role_permissions() {
		$role_model_name = Configure::read('acl.aro.role.model');

		$role_display_field = Configure::read('acl.aro.role.display_field');

		//$this->set('role_model_name', $role_model_name);
		$this->set('role_display_field', $role_display_field);
		//$this->set('role_pk_name',       $this->_get_role_primary_key_name());

		$this->{$role_model_name}->recursive = -1;
		$roles                               = $this->{$role_model_name}->find('all', array(
				'order' => $role_display_field,
				'contain' => false,
				'recursive' => -1
			));

		//?controller=3&plugin=&controller=AdminUsers
		$controller = $this->params['url']['controller'];
		if ($controller) {
			if ($controller === "all") {
			} else {
				$controller_actions = $this->AclReflector->get_controller_actions($controller);
				$methods            = array();
				foreach ($controller_actions as $controller_action) {
					$methods['app'][$controller][] = array(
						'name' => $controller_action,
						'permissions' => $permissions
					);
				}
				$this->set('roles', $roles);
				$this->set('actions', $methods);
				return;
			}

		} else {
			$controllers = $this->AclReflector->get_all_app_controllers();
			foreach ($controllers as $controller) {
				$controller_class_name[] = $controller['name'];

			}
			$this->set('controllers', $controller_class_name);
			return;
		}

		$actions = $this->AclReflector->get_all_actions();
		$methods = array();
		foreach ($actions as $full_action) {
			$arr = String::tokenize($full_action, '/');
			if (count($arr) == 2) {
				$plugin_name     = null;
				$controller_name = $arr[0];
				$action          = $arr[1];
			} elseif (count($arr) == 3) {
				$plugin_name     = $arr[0];
				$controller_name = $arr[1];
				$action          = $arr[2];
			}
			//ajaxで変更しない場合は以下を使用する

			/*
      foreach($roles as $role)
      {
      $aro_node = $this->Acl->Aro->node($role);
      if(!empty($aro_node))
      {
      $aco_node = $this->Acl->Aco->node($full_action);
      if(!empty($aco_node))
      {
      $authorized = $this->Acl->check($role, $full_action);
      $permissions[$role[Configure :: read('acl.aro.role.model')][$this->_get_role_primary_key_name()]] = $authorized ? 1 : 0 ;
      }
      }
      else
      {

      //No check could be done as the ARO is missing

      $permissions[$role[Configure :: read('acl.aro.role.model')][$this->_get_role_primary_key_name()]] = -1;
      }
      }
      */
			if (isset($plugin_name)) {
				$methods['plugin'][$plugin_name][$controller_name][] = array(
					'name' => $action,
					'permissions' => $permissions
				);
			} else {
				$methods['app'][$controller_name][] = array(
					'name' => $action,
					'permissions' => $permissions
				);
			}
		}
		$this->set('roles', $roles);
		$this->set('actions', $methods);
		//$controllers = $this->get();
	}

	function get_role_controller_permission($role_id) {
		$role =& $this->{Configure::read('acl.aro.role.model')};
		$role_id   = $this->params['url']['role_id'];
		$role_data = $role->read(null, $role_id);

		$aro_node = $this->Acl->Aro->node($role_data);
		if (!empty($aro_node)) {
			//?role_id=3&plugin=&controller=AdminUsers
			$plugin_name        = $this->params['url']['plugin'];
			$controller_name    = $this->params['url']['controller'];
			$controller_actions = $this->AclReflector->get_controller_actions($controller_name);

			$role_controller_permissions = array();

			foreach ($controller_actions as $action_name) {
				$aco_path = $plugin_name;
				$aco_path .= empty($aco_path) ? $controller_name : '/' . $controller_name;
				$aco_path .= '/' . $action_name;

				$aco_node = $this->Acl->Aco->node($aco_path);
				if (!empty($aco_node)) {
					$authorized                                = $this->Acl->check($role_data, $aco_path);
					$role_controller_permissions[$action_name] = $authorized;
				} else {
					$role_controller_permissions[$action_name] = -1;
				}
			}
		} else {
			//$this->set('acl_error', true);
			//$this->set('acl_error_aro', true);
		}

		if ($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0); //-> to disable printing of generation time preventing correct JSON parsing
			echo json_encode($role_controller_permissions);
			$this->autoRender = false;
		} else {
			$this->_return_to_referer();
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid admin user', true));
			$this->redirect(array(
					'action' => 'index'
				));
		}
		$this->set('adminUser', $this->AdminUser->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->AdminUser->create();
			//userModel!=loginAciton元Actionのとき以下必要？
			//$this->data['AdminUser']['password'] = $this->Auth->password($this->data['AdminUser']['password']);
			if ($this->AdminUser->save($this->data)) {
				$this->Session->setFlash(__('The admin user has been saved', true));
				$this->redirect(array(
						'action' => 'index'
					));
			} else {
				$this->Session->setFlash(__('The admin user could not be saved. Please, try again.', true));
			}
		}
		$user        = $this->Auth->User();
		//自分より権限の弱いグループのみを取得
		$adminGroups = $this->AdminUser->AdminGroup->find('list', array(
				'conditions' => array(
					'AdminGroup.id >=' => $user['AdminUser']['admin_group_id']
				)
			));
		$this->set(compact('adminGroups'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid admin user', true));
			$this->redirect(array(
					'action' => 'index'
				));
		}
		if (!empty($this->data)) {
			if ($this->AdminUser->save($this->data)) {
				$this->Session->setFlash(__('The admin user has been saved', true));
				$this->redirect(array(
						'action' => 'index'
					));
			} else {
				$this->Session->setFlash(__('The admin user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AdminUser->read(null, $id);
		}
		$adminGroups = $this->AdminUser->AdminGroup->find('list');
		$this->set(compact('adminGroups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for admin user', true));
			$this->redirect(array(
					'action' => 'index'
				));
		}
		if ($this->AdminUser->delete($id)) {
			$this->Session->setFlash(__('Admin user deleted', true));
			$this->redirect(array(
					'action' => 'index'
				));
		}
		$this->Session->setFlash(__('Admin user was not deleted', true));
		$this->redirect(array(
				'action' => 'index'
			));
	}


}
