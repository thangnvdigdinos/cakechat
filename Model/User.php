<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @property 1 $1
 */
class User extends AppModel {
	public $name = 'User';
	
	public $primaryKey = 'id';
	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useTable = 'users';
	
	var $hasMany = array('Thread');
	
	public function beforeSave($options = Array())
	{
		if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new SimplePasswordHasher();
	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
		}
		return true;
	}
	
	/**
	 * Checking owner user
	 * @param User object $userId
	 * @param User object $user
	 */
	public function isOwnedBy($userId, $user) {
	    return $this->field('id', array('id' => $userId, 'id' => $user)) === $userId;
	}
}