<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public function beforeFilter()
    {
        $this->Auth->allow('index', 'add', 'logout');
    }

    /**
     * Verify authorized user
     * @see AppController::isAuthorized()
     * 
     * @author ThangNV
     **/
    public function isAuthorized($user) 
    {
        // All guest can register user
        if ($this->action === 'add') {
            return true;
        }

        // The owner of a thread can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $userId = $this->request->params['pass'][0];
            if ($this->User->isOwnedBy($userId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * Login method for authen method required
     * 
     * @author ThangNV
     **/
    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            	
            $this->Session->setFlash(__('Invalid username or password, please try again'));
        }
    }

    /**
     * Logout of system
     * 
     * @author ThangNV
     **/
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * List all users
     * 
     * @author ThangNV
     **/
    public function index()
    {
        $this->set('users', $this->User->find('all'));
    }

    /**
     * View user detail
     * @param string $id: id of user
     * @throws NotFoundException
     * 
     * @author ThangNV
     **/
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid account id'));
        }
        $this->set('user', $user);
    }

    /**
     * Edit user info
     * @param string $id: id of user
     * @throws NotFoundException
     * 
     * @author ThangNV
     **/
    public function edit($id = null) 
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid account'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your account has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to update your account.'));
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }

    /**
     * Add user info
     * 
     * @author ThangNV
     **/
    public function add()
    {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your account has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your account.'));
        }
    }

    /**
     * Delete user out of system
     * @param int $id: id of user
     * @throws MethodNotAllowedException
     * 
     * @author ThangNV
     **/
    public function delete($id) 
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->User->delete($id)) {
            $this->Session->setFlash(__('The post with id: %s has been deleted.', h($id)));
            return $this->redirect(array('action' => 'index'));
        }
    }
}
