<?php

class AclAppController extends AppController {
	var $layout      = 'admins';

	/**
   * 初期設定
   * AdminAppControllerを継承する場合は
   * コンポーネントにAcl, Authを追加すること
   */
  public function beforeFilter() {
    // 認証関連
    $this->_setAuth();

    $this->_check_config();

    parent::beforeFilter();

    $this->set('is_acl', true);
  }

  /**
   * _setAuth
   *
   * 認証関連の初期化
   */
  private function _setAuth() {
    //$this->Auth->allow('*');

    $this->Auth->actionPath = 'controllers/';
    $this->Auth->authorize = 'actions';

    // 以下必要に応じてAuthコンポーネントのメソッドを設定してください

    $this->Auth->userModel  = 'AdminUser';
    $this->Auth->authError = 'ログインしてください';
    $this->Auth->loginError = 'ログインに失敗しました。';

    $this->Auth->loginAction = array('controller' => 'admin_users', 'action'     => 'login');
    $this->Auth->loginRedirect = array('controller' => 'admin_users', 'action' => 'aros_index');
    $this->Auth->logoutRedirect = array('controller' => 'admin_users', 'action' => 'login');
  }

	private function _check_config() {
	  $role_model_name = Configure :: read('acl.aro.role.model');

		if (!empty($role_model_name)) {
	    $this->set('role_model_name',    $role_model_name);
	    $this->set('user_model_name',    Configure :: read('acl.aro.user.model'));
	    $this->set('role_pk_name',       $this->_get_role_primary_key_name());
	    $this->set('user_pk_name',       $this->_get_user_primary_key_name());
	    $this->set('role_fk_name',       $this->_get_role_foreign_key_name());

	    $this->_authorize_admins();
		} else {
	    //$this->Session->setFlash(__d('acl', 'The role model name is unknown. The ACL plugin bootstrap.php file has to be loaded in order to work. (see the README file)', true), 'flash_error', null, 'plugin_acl');
	  }
	}

	function _authorize_admins() {
		$authorized_role_ids = Configure :: read('acl.role.access_all_role_ids');
		$authorized_user_ids = Configure :: read('acl.role.access_all_user_ids');

		$model_role_fk = $this->_get_role_foreign_key_name();

    if (in_array($this->Auth->user($model_role_fk), $authorized_role_ids)
       || in_array($this->Auth->user($this->_get_user_primary_key_name()), $authorized_user_ids)) {
      $this->Auth->allow('*');
	  }
	}

  function _get_role_primary_key_name() {
	  $forced_pk_name = Configure :: read('acl.aro.role.primary_key');
	  if (!empty($forced_pk_name)) {
	    return $forced_pk_name;
	  } else {
	    /*
	     * Return the primary key's name that follows the CakePHP conventions
	     */
	    return 'id';
	  }
	}

	function _get_user_primary_key_name() {
	  $forced_pk_name = Configure :: read('acl.aro.user.primary_key');
	  if (!empty($forced_pk_name)) {
	    return $forced_pk_name;
	  } else {
      /*
       * Return the primary key's name that follows the CakePHP conventions
       */
	    return 'id';
	  }
	}

	function _get_role_foreign_key_name() {
	  $forced_fk_name = Configure :: read('acl.aro.role.foreign_key');
	  if (!empty($forced_fk_name)) {
	    return $forced_fk_name;
	  } else {
      /*
       * Return the foreign key's name that follows the CakePHP conventions
       */
	    return Inflector :: underscore(Configure :: read('acl.aro.role.model')) . '_id';
	  }
	}

	function _get_passed_aco_path() {
	  $aco_path  = isset($this->params['url']['plugin']) ? $this->params['named']['plugin'] : '';
    $aco_path .= empty($aco_path) ? $this->params['url']['controller'] : '/' . $this->params['url']['controller'];
    $aco_path .= '/' . $this->params['url']['action'];

    return $aco_path;
	}

	function _set_aco_variables() {
    $this->set('plugin', isset($this->params['url']['plugin']) ? $this->params['url']['plugin'] : '');
    $this->set('controller_name', $this->params['url']['controller']);
    $this->set('action', $this->params['url']['action']);
	}

  function _return_to_referer() {
	  $this->redirect($this->referer(array('action' => 'index')));
	}
}

?>