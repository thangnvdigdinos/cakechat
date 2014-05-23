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
use \ElasticSearch\Client;
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MessagesController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	public $uses = array('Message','Thread');
	
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
		),
		'content' => array(
			'rule' => 'notEmpty'
		)
	);
	
	public function beforeFilter()
	{
		$this->Auth->allow('index', 'view', 'getLatestMessage');
	}
	
	/************************************************
	 * Verify authorized user
	 * @see AppController::isAuthorized()
	 ************************************************/
	public function isAuthorized($user) {
	    // All registered users can add posts
	    if ($this->action === 'add') {
	        return true;
	    }
	
	    // The owner of a message can edit and delete it
	    if (in_array($this->action, array('edit', 'delete'))) {
	        $messageId = $this->request->params['pass'][0];
	        if ($this->Message->isOwnedBy($messageId, $user['id'])) {
	            return true;
	        }
	    }
	
	    return parent::isAuthorized($user);
	}
	
	/************************************************
	 * List all message in Message table
	 ************************************************/
	public function index()
	{
		$this->set('messages', $this->Message->findByStatus('0'));
	}
	
	/************************************************
	 * View message detail
	 * @param string $id: id of message
	 * @throws NotFoundException
	 ************************************************/
	public function view($id = null)
	{
		if(!$id)
		{
			throw new NotFoundException(__('Invalid post'));
		}
		
		$message = $this->Message->findById($id);
		if (!$message) {
			throw new NotFoundException(__('Invalid account id'));
		}
		$this->set('message', $message);
	}

	/************************************************
	 * Edit message info
	 * @param string $id: id of message
	 * @throws NotFoundException
	 ************************************************/
	public function edit($id = null, $threadId = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved'));
				
				//after save message then redirect to thread detail page
				return $this->redirect(array('controller' => 'threads', 'action' => 'view', $this->request->data['Message']['thread_id']));
			}
			$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
		} else {
			$this->request->data = $this->Message->read(null, $id);
			unset($this->request->data['Message']['password']);
		}
	}
	
	/************************************************
	 * Add a message
	 ************************************************/	
	public function add()
	{
		if($this->request->is('post'))
		{
			$this->request->data['Message']['user_id'] = $this->Auth->user('id');
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('Your message has been saved.'));
				
				// The recommended way to go about things is to use an environment variable called ELASTICSEARCH_URL
                $es = Client::connection();

                // Alternatively you can use dsn string
                $es = Client::connection('http://172.17.1.188:9200/chatsystem/message');
                $es->index($this->request->data, $id);
                $es->get($id);

				//after save message then redirect to thread detail page
				return $this->redirect(array('controller' => 'threads', 'action' => 'view', $this->request->data['Message']['thread_id']));
			}
			$this->Session->setFlash(__('Unable to add your message.'));
		}
		else 
		{
			$this->set('threadid', $this->params['named']['threadid']);
		}
	}
	
	/************************************************
	 * Delete a message
	 * @param int $id: id of message
	 * @param int $id: id of thread
	 * @throws NotFoundException
	 ************************************************/
	public function delete($id, $threadId)
	{
		if(!isset($id))
		{
			throw new NotFoundException(__("Invalid Message Id"));
		}
		
		if($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}
		
		if($this->request->is('post'))
		{
			$this->request->data = $this->Message->findById($id);
			$this->request->data['Message']['status'] = 1;
			if($this->Message->save($this->request->data))
			{
				$this->Session->setFlash(__("Your message has been deleted."));
				return $this->redirect(array('controller' => 'threads', 'action' => 'view', $threadId));
			}
			$this->Session->setFlash(__("Unable to delete this message."));
		}
	}
	
	/**
	 * Get latest message by threadId and messageId
	 * Enter description here ...
	 * @param unknown_type $threadId
	 * @param unknown_type $messageId
	 */
	public function getLatestMessage($threadId, $messageId){
		$responseData = array('status' => 'success', 'data' => '', 'error' => '');
		//if($this->request->is('ajax')){
			$this->disableCache();
			
			$this->autoRender = false;
			// Render message list
			$messages = $this->Message->getMessages($threadId, $messageId);
			
	        // Render message list
	        $view = new View($this, false);
	        $view->layout = false;
	        $view->set(compact('messages', $messages));
	        $view->viewPath = 'Messages';
	        $message_with_template = $view->render('messages');

	        // Set response data
        	$responseData['data']['messages'] = $message_with_template;
        	$responseData['data']['count'] = count($messages);
        	$responseData['data']['status'] = 'success';
			
        	var_dump($responseData);
			header('Content-Type: application/json');
        	echo json_encode($responseData);
		//}
	}
}
