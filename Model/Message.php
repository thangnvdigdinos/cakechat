<?php
App::uses('CakeSession', 'Model/Datasource');
/**
 * Message Model
 *
 * @property 1 $1
 */
class Message extends AppModel {
	public $name = 'Message';
	
	public $primaryKey = 'id';
	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useTable = 'messages';
	
	// Which db table to use
	//var $belongsTo = array('Thread','User');
	
	/**
	* Pre processing data before saving into db
	*/
	public function beforeSave($options = Array())
	{
//		if($this->data)
//		{
//			$uid = CakeSession::read("Auth.User.id");
//			$this->data[$this->alias]['user_id'] = $uid;
//		}

		return true;
	}
	
	/**
	 * Checking owner message
	 * @param Message object $message
	 * @param User object $user
	 */
	public function isOwnedBy($message, $user) {
	    return $this->field('id', array('id' => $message, 'user_id' => $user)) === $message;
	}
	
	public function getMessages($threadId, $messageId){
        $conditions = array(
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('Message.user_id = User.id'),
                ),
                array(
                    'table' => 'threads',
                    'alias' => 'Thread',
                    'type' => 'inner',
                    'conditions' => array('Thread.id = Message.thread_id'),
                )
            ),
            'fields' => array('Message.*', 'User.username'),
            'conditions' => array('Message.id > ' . $messageId .
                ' AND Message.thread_id = '.$threadId),
            'order' => array('Message.id' => 'DESC')
        );

        return $this->find('all', $conditions);
	}
}