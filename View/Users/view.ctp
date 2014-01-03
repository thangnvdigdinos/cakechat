<!-- File: /app/View/Users/view.ctp -->
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">Menu</div>
		<div class="panel-body">
			<li>
				<?php echo $this->Html->link(
					'Accounts',
					array('controller' => 'users', 'action' => 'index')
				);?>
			</li>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
	        <h3 class="panel-title">User Detail</h3>
		</div>
		<div class="panel-body">
			<li>
		        <?php echo __('Username')?> : <?php echo h($user['User']['username']); ?>
			</li>
			<li>
				<?php echo __('Created')?> : <?php echo $user['User']['created']; ?>
			</li>
		</div>
	</div>
</div>