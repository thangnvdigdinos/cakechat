<!-- File: /app/View/Threads/add.ctp -->
<h2>Threads</h2>
<?php echo $this->Html->link(
'Threads',
array('controller' => 'threads', 'action' => 'index')
); ?>
<?php
echo $this->Form->create('Thread');
echo $this->Form->input('thread_title');
echo $this->Form->input('thread_content');
echo $this->Form->end('Create Thread');
?>