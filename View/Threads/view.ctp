<!-- File: /app/View/Threads/view.ctp -->
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">Menu</div>
		<div class="panel-body">
			<li>
				<?php echo $this->Html->link(
					'Threads',
					array('controller' => 'threads', 'action' => 'index')
				);?>
			</li>
			<br>
			<h3>Title: <?php echo h($thread['Thread']['thread_title']); ?></h3>
	        <li>
		        Created by: <?php echo $thread['User']['username']; ?>
			</li>
			<li>
				Created at: <?php echo $thread['Thread']['created']; ?>
			</li>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
	        <h3 class="panel-title">Thread: <?php echo h($thread['Thread']['thread_content']); ?></h3>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Content</th>
					<th>Actions</th>
					<th>Owner</th>
					<th>Created</th>
					<th>Updated</th>
				</tr>
			</thead>
			<?php foreach ($thread['Message'] as $message): ?>
			<tbody>
				<tr>
					<td><?php echo $message['id']; ?></td>
					<td>
						<?php 
							if($message['status'] ==1) 
							{
								echo "<p style='color:red'>".$message['content']; 
								echo " (Has removed)</p>"; 
							}
							else{
								echo $message['content'];
							}
						?>
					</td>
					<td>
					<?php
						if($message['status'] != 1){
							echo $this->Form->postLink(
								'Delete',
								array('controller' => 'messages', 'action' => 'delete', $message['id'], $thread['Thread']['id']),
								array('confirm' => __('are you sure to delete?'))
							);
							echo "/";
							echo $this->Html->link(
								'Edit',
								array('controller' => 'threads', 'action' => 'view', $thread['Thread']['id'], $message['id'])
							);
						}
					?>
					</td>
					<td><?php echo $thread['User']['username']; ?></td>
					<td><?php echo $message['created']; ?></td>
					<td><?php echo $message['updated']; ?></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
			<?php unset($message); ?>
		</table>
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<?php
			$options = array(
			    'label' => 'Search Message',
			    'class' => 'btn btn-default');
			echo $this->Form->create('Thread', array(
			'class' => 'navbar-form navbar-left',
			'url' => '/threads/view',
			'role' => 'message',
			'inputDefaults' => array(
			    'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			    'div' => array('class' => 'form-group'),
			    'class' => array('form-control'),
			    'label' => array('class' => 'navbar-text'),
			    'between' => '<div class="form-group">',
			    'after' => '</div>',
			    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
			)));
			echo $this->Form->input('thread_id', array('type' => 'hidden', 'value' => $thread['Thread']['id']));
			echo $this->Form->input('content');
			echo $this->Form->end($options);
		?>
		</div>
	</nav>
	<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<?php
			$options = array(
			    'label' => 'Save Message',
			    'class' => 'btn btn-default');
			echo $this->Form->create('Message', array(
			'class' => 'navbar-form navbar-left',
			'url' => $url,
			'role' => 'message',
			'inputDefaults' => array(
			    'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			    'div' => array('class' => 'form-group'),
			    'class' => array('form-control'),
			    'label' => array('class' => 'navbar-text'),
			    'between' => '<div class="form-group">',
			    'after' => '</div>',
			    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
			)));
			echo $this->Form->input('thread_id', array('type' => 'hidden', 'value' => $thread['Thread']['id']));
			echo $this->Form->input('content');
			echo $this->Form->end($options);
		?>
		</div>
	</nav>
</div>