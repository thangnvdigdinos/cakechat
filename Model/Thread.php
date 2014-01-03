<?php
App::uses('CakeSession', 'Model/Datasource');
/**
 * Thread Model
 *
 * @property 1 $1
 */
class Thread extends AppModel {
	public $name = 'Thread';
	
	public $primaryKey = 'id';
	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useTable = 'threads';
	
	var $hasMany = array('Message');
	
	// Which db table to use
	var $belongsTo = array('User');
	
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
	 * Checking owner thread
	 * @param Thread object $thread
	 * @param User object $user
	 */
	public function isOwnedBy($thread, $user) {
	    return $this->field('id', array('id' => $thread, 'user_id' => $user)) === $thread;
	}
	
	public function getThreadById(){
		
	}
}