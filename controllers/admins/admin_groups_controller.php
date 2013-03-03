<?php
class AdminGroupsController extends AclAppController {
  var $name = 'AdminGroups';
  var $layout = 'admins';
  var $components = array('Acl', 'Auth');

  /**
   * themeの設定
   */
  var $theme = 'admin';

  function index() {
    $this->AdminGroup->recursive = 0;
    $this->set('adminGroups', $this->paginate());
  }

  function view($id = null) {
    if (!$id) {
      $this->Session->setFlash(__('Invalid admin group', true));
      $this->redirect(array(
        'action' => 'index'
      ));
    }
    $this->set('adminGroup', $this->AdminGroup->read(null, $id));
  }

  function add() {
    if (!empty($this->data)) {
      $this->AdminGroup->create();
      if ($this->AdminGroup->save($this->data)) {
        $this->Session->setFlash(__('The admin group has been saved', true));
        $this->redirect(array(
          'action' => 'index'
        ));
      } else {
        $this->Session->setFlash(__('The admin group could not be saved. Please, try again.', true));
      }
    }
  }

  function edit($id = null) {
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(__('Invalid admin group', true));
      $this->redirect(array(
        'action' => 'index'
      ));
    }
    if (!empty($this->data)) {
      if ($this->AdminGroup->save($this->data)) {
        $this->Session->setFlash(__('The admin group has been saved', true));
        $this->redirect(array(
          'action' => 'index'
        ));
      } else {
        $this->Session->setFlash(__('The admin group could not be saved. Please, try again.', true));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->AdminGroup->read(null, $id);
    }
  }

  function delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for admin group', true));
      $this->redirect(array(
        'action' => 'index'
      ));
    }
    if ($this->AdminGroup->delete($id)) {
      $this->Session->setFlash(__('Admin group deleted', true));
      $this->redirect(array(
        'action' => 'index'
      ));
    }
    $this->Session->setFlash(__('Admin group was not deleted', true));
    $this->redirect(array(
      'action' => 'index'
    ));
  }

}
