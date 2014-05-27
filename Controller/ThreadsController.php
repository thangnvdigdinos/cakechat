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
class ThreadsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('Message','Thread');

    public $validate = array(
	    'threadname' => array(
		    'rule' => 'notEmpty'
    ),
		'body' => array(
            'rule' => 'notEmpty'
    )
    );

    public function beforeFilter()
    {
        $this->Auth->allow('index', 'view');
    }

    /**
     * Verify authorized user
     * @see AppController::isAuthorized()
     **/
    public function isAuthorized($user)
    {
        // All registered users can add thread
        if ($this->action === 'add') {
            return true;
        }

        // The owner of a thread can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $threadId = $this->request->params['pass'][0];
            if ($this->Thread->isOwnedBy($threadId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * List all threads in Thread table
     **/
    public function index()
    {
        $this->set('threads', $this->Thread->find('all'));
    }

    /**
     * View thread detail
     * @param string $id: id of thread
     * @param string $messageId: id of message
     * @throws NotFoundException
     **/
    public function view($id = null, $messageId = null)
    {
        $lastUpdated = "";
        if ($this->request->is('get')) {
            if (!$id) {
                throw new NotFoundException(__('Invalid thread'));
            }

            $thread = $this->Thread->findById($id);
            if (!$thread) {
                throw new NotFoundException(__('Invalid thread id'));
            }
            $this->set('thread', $thread);
            if (isset($thread['Message']) && count($thread['Message']) > 0) {
                $lastMessage = $thread['Message'][count($thread['Message']) -1];
                $this->set('lastUpdated', $lastMessage['updated']);
            }
        }

        if (isset($messageId)) {
            $message = $this->Message->findById($messageId);
            if (!isset($message)) {
                throw new NotFoundException();
            }
            $this->request->data = $message;
             
            $url = array('controller' => 'messages', 'type' => 'post', 'action' => 'edit', 'threadid' => $id);
        } else {
            $url = array('controller' => 'messages', 'action' => 'add', 'threadid' => $id);
        }

        $this->set('url', $url);
    }

    /**
     * Edit thread info
     * @param string $id: id of thread
     * @throws NotFoundException
     **/
    public function edit($id = null)
    {
        $this->Thread->id = $id;
        if (!$this->Thread->exists()) {
            throw new NotFoundException(__('Invalid thread'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Thread']['user_id'] = $this->Auth->user('id');
            if ($this->Thread->save($this->request->data)) {
                $this->Session->setFlash(__('The thread has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The thread could not be saved. Please try again.'));
        } else {
            $this->request->data = $this->Thread->read(null, $id);
        }
    }

    /**
     * Add a thread
     **/
    public function add()
    {
        if ($this->request->is('post')) {
            $this->request->data['Thread']['user_id'] = $this->Auth->user('id');
            $this->Thread->create();
            if ($this->Thread->save($this->request->data)) {
                $this->Session->setFlash(__('Your thread has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add this thread.'));
        }
    }

    /**
     * Delete a thread
     * @param int $id: id of thread
     * @throws NotFoundException
     **/
    public function delete($id)
    {
        if (!isset($id)) {
            throw new NotFoundException(__("Invalid Thread Id"));
        }

        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->request->is('post')) {
            if ($this->Thread->delete($id, true)) {
                $this->Session->setFlash(__("Your thread has been deleted."));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__("Unable to delete this thread."));
        }
    }

    /**
     * Search with input condition
     * 
     * @author ThangNV
     */
    public function search()
    {
        if ($this->request->is('post')) {
            $content = $this->request->data['Thread']['content'];
            //Prepare param for building searching input params
            $params['index'] = Configure::read('chatsystem_index');
            $params['type']  = Configure::read('message_type');
            $params['body']['query']['match']['content'] = $content;

            $esUtility = ElasticSearchUtility::getInstance();
            $messages = $esUtility->search($params);
            var_dump($messages);die;
            $this->set('thread', $messages);
        }
    }
}
