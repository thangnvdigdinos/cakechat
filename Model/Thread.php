<?php
App::uses('CakeSession', 'Model/Datasource');

/**
 * Thread Model
 *
 * @author ThangNV
 */
class Thread extends AppModel {

    public $name = 'Thread';
    public $primaryKey = 'id';
    public $useTable = 'threads';

    var $hasMany = array('Message');
    var $belongsTo = array('User');

    /**
     * Pre processing data before saving into db
     *
     * @author ThangNV
     */
    public function beforeSave($options = Array())
    {
        return true;
    }

    /**
     * Checking owner thread
     * @param Thread object $thread
     * @param User object $user
     *
     * @author ThangNV
     */
    public function isOwnedBy($thread, $user) 
    {
        return $this->field('id', array('id' => $thread, 'user_id' => $user)) === $thread;
    }
    
}