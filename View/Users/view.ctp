<!-- File: /app/View/Users/view.ctp -->
<p>
<?php echo $this->Html->link(
'Accounts',
array('controller' => 'users', 'action' => 'index')
); ?>
</p>
<h2>User Detail</h2>
<br>
<p>Username: <?php echo h($user['User']['username']); ?></p>
<p>Created: <?php echo $user['User']['created']; ?></p>