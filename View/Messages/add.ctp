<!-- File: /app/View/Messages/add.ctp -->
<h1>Add message</h1>
<?php echo $this->Html->link(
'Index Message',
array('controller' => 'messages', 'action' => 'index')
); 
?>
<?php
echo $this->Form->create('Message');
echo $this->Form->input('title');
echo $this->Form->input('content', array('rows' => '3'));
echo $this->Form->input('thread_id', array('type' => 'hidden', 'value' => $threadid));
echo $this->Form->end('Create Message');
?>