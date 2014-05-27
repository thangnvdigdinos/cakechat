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
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      		<ul class="nav navbar-nav">
		        <form method="post" class="navbar-form navbar-left" action="<?php echo $search_url;?>" role="search">
                		<div class="form-group">
		                    <input type="text" name="data[Message][content]" id="MessageContent" class="form-control" 
					placeholder="Search" value="<?php echo $content; ?>">
                		</div>
                		<button type="submit" class="btn btn-default">Search</button>
		        </form>
		</ul>
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
			<?php 
				if (is_array($threads) && count($threads) > 0)
				foreach ($threads['Message'] as $message): ?>
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
</div>
