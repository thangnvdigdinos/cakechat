<!-- File: /app/View/Users/edit.ctp -->
<h2>Edit User</h2>
<?php
echo $this->Form->create('Users');
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save User');
?>