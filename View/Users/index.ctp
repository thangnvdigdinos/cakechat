<!-- File: /app/View/Users/index.ctp -->
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo __('Menu');?>
		</div>
		<div class="panel-body">
			<li>
				<?php echo $this->Html->link(
					'Add Account',
					array('controller' => 'users', 'action' => 'add')
				); ?>
			</li>
			<li>
			<?php echo $this->Html->link(
				'Index Thread',
				array('controller' => 'threads', 'action' => 'index')
			); ?>
			</li>
			<li>
				<?php echo $this->Html->link(
					'Create Thread',
					array('controller' => 'threads', 'action' => 'add')
				); ?>
			</li>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
	        <h3 class="panel-title"><?php echo __('Users');?></h3>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th><?php echo __('Id');?></th>
					<th><?php echo __('User name');?></th>
					<th><?php echo __('Actions');?></th>
					<th><?php echo __('Created');?></th>
				</tr>
			</thead>
			<?php foreach ($users as $user): ?>
			<tbody>
				<tr>
					<td><?php echo $user['User']['id']; ?></td>
					<td>
						<?php 
							echo $this->Html->link(
								$user['User']['username'],
								array('controller' => 'users', 'action' => 'view', $user['User']['id'])
							); 
						?>
					</td>
					<td>
						<?php
							echo $this->Form->postLink(
								'Delete',
								array('action' => 'delete', $user['User']['id']),
								array('confirm' => __('Are you sure?'))
							);
						?>
						/
						<?php
							echo $this->Html->link(
								'Edit',
								array('action' => 'edit', $user['User']['id'])
							);
						?>
					</td>
					<td><?php echo $user['User']['created']; ?></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
			<?php unset($user); ?>
		</table>
	</div>
</div>