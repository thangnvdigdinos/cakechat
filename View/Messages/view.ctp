<!-- File: /app/View/Message/view.ctp -->
<p>
<?php echo $this->Html->link(
'Index Message',
array('controller' => 'messages', 'action' => 'index')
); ?>
</p>
<h2>Message Detail</h2>
<br>
<h1><?php echo h($message['Message']['title']); ?></h1>
<h3><?php echo h($message['Message']['content']); ?></h3>
<p><small>Created: <?php echo $message['Message']['created']; ?></small></p>