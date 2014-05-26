<?php
App::uses('CakeSession', 'Model/Datasource');

/**
 * Message Model
 *
 * @author ThangNV
 */
class Message extends AppModel {

    public $name = 'Message';
    public $primaryKey = 'id';
    public $useTable = 'messages';

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
     * Checking owner message
     * @param Message object $message
     * @param User object $user
     * 
     * @author ThangNV
     */
    public function isOwnedBy($message, $user) 
    {
        return $this->field('id', array('id' => $message, 'user_id' => $user)) === $message;
    }

    /**
     *
     * Get message detail by thread id and message id
     * @param int $threadId
     * @param int $messageId
     * 
     * @author ThangNV
     */
    public function getMessages($threadId, $messageId)
    {
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