<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @author ThangNV
 */
class User extends AppModel {
    
	public $name = 'User';
	public $primaryKey = 'id';
	public $useTable = 'users';
	
	var $hasMany = array('Thread');

	/**
	* Pre processing data before saving into db
	* 
	* @author ThangNV
	*/
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
	 * 
	 * @author ThangNV
	 */
	public function isOwnedBy($userId, $user) {
	    return $this->field('id', array('id' => $userId, 'id' => $user)) === $userId;
	}
}