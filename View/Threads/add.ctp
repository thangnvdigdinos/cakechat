<!-- File: /app/View/Threads/add.ctp -->
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo __('Menu');?></div>
		<div class="panel-body">
			<li>
				<?php echo $this->Html->link(
					__('Threads'),
					array('controller' => 'threads', 'action' => 'index')
				);?>
			</li>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
	        <h3 class="panel-title"><?php echo __('Create Thread');?></h3>
		</div>
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<?php
			$options = array(
			    'label' => 'Save Thread',
			    'class' => 'btn btn-default');
			echo $this->Form->create('Thread', array(
			'class' => 'navbar-form navbar-left',
			'role' => 'thread',
			'inputDefaults' => array(
			    'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			    'div' => array('class' => 'form-group'),
			    'class' => array('form-control'),
			    'label' => array('class' => 'navbar-text'),
			    'between' => '<div class="form-group">',
			    'after' => '</div>',
			    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
			)));
			echo $this->Form->input('thread_title');
			echo $this->Form->input('thread_content');
			echo $this->Form->end($options);
		?>
		</div>
	</nav>
</div>