<div class="row">
	<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php 
			$options = array(
			    'label' => __('Login'),
			    'class' => 'btn btn-default');
			echo $this->Form->create('User', array(
			'class' => 'form-horizontal', 
			'role' => 'login',
			'inputDefaults' => array(
			    'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			    'div' => array('class' => 'form-group'),
			    'class' => array('form-control'),
			    'label' => array('class' => 'navbar-text'),
			    'between' => '<div class="form-group">',
			    'after' => '</div>',
			    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
			)));
			?>
		    <legend><?php echo __('Username and password'); ?></legend>
		    <?php echo $this->Form->input('username'); ?>
		    <?php echo $this->Form->input('password', array('label' => array('text' => 'Password', 'class' => 'navbar-text'))); ?>
			<?php echo $this->Form->end($options);?>
		</div>
	</nav>
</div>