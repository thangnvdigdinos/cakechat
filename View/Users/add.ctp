<!-- File: /app/View/Users/add.ctp -->
<h2>Add account</h2>
<p>
<?php echo $this->Html->link(
'Index Account',
array('controller' => 'users', 'action' => 'index')
); ?>
</p>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Create Account');
?>