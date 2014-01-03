<!-- File: /app/View/Messages/index.ctp -->
<h2>Messages</h2>
<?php echo $this->Html->link(
'Add Message',
array('controller' => 'messages', 'action' => 'add')
); ?>
<table>
<tr>
<th>Id</th>
<th>Content</th>
<th>Actions</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $messages array, printing out post info -->
<?php foreach ($messages as $message): ?>
<tr>
<td><?php echo $message['Message']['id']; ?></td>
<td>
<?php echo $this->Html->link($message['Message']['title'],
array('controller' => 'messages', 'action' => 'view', $message['Message']['id'])); ?>
</td>
<td>
<?php
echo $this->Form->postLink(
'Delete',
array('action' => 'delete', $message['User']['id']),
array('confirm' => 'Are you sure?')
);
?>
/
<?php
echo $this->Html->link(
'Edit',
array('action' => 'edit', $message['User']['id'])
);
?>
</td>
<td><?php echo $message['Message']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($message); ?>
</table>