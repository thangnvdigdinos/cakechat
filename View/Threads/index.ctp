<!-- File: /app/View/Threads/index.ctp -->
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Menu
		</div>
		<div class="panel-body">
			<li>
				<?php echo $this->Html->link(
					__('Create Thread'),
					array('controller' => 'threads', 'action' => 'add')
				); ?>
			</li>
			<li>
				<?php echo $this->Html->link(
					__('Users'),
					array('controller' => 'users', 'action' => 'index')
				); ?>
			</li>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
	        <h3 class="panel-title">Threads</h3>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th><?php echo __('Id');?></th>
					<th><?php echo __('Thread title');?></th>
					<th><?php echo __('Actions');?></th>
					<th><?php echo __('Owner name');?></th>
					<th><?php echo __('Created');?></th>
				</tr>
			</thead>
			<?php foreach ($threads as $thread): ?>
			<tbody>
				<tr>
					<td><?php echo $thread['Thread']['id']; ?></td>
					<td>
						<?php 
							echo $this->Html->link(
								$thread['Thread']['thread_title'],
								array('controller' => 'threads', 'action' => 'view', $thread['Thread']['id'])
							); 
						?>
					</td>
					<td>
						<?php
							echo $this->Form->postLink(
								'Delete',
								array('action' => 'delete', $thread['Thread']['id']),
								array('confirm' => __('Are you sure?'))
							);
						?>
						/
						<?php
							echo $this->Html->link(
								'Edit',
								array('action' => 'edit', $thread['Thread']['id'])
							);
						?>
					</td>
					<td>
						<?php 
							echo $this->Html->link(
								$thread['User']['username'],
								array('controller' => 'users', 'action' => 'view', $thread['User']['id'])
							); 
						?>
					</td>
					<td><?php echo $thread['Thread']['created']; ?></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
			<?php unset($thread); ?>
		</table>
	</div>
</div>