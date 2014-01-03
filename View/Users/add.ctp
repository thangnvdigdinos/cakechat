<!-- File: /app/View/Users/add.ctp -->
<!--
<h2>Add account</h2>
<p>
<?php echo $this->Html->link(
'Index Account',
array('controller' => 'users', 'action' => 'index')
); ?>
</p>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Create Account');
?>
-->
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo __('Menu');?></div>
		<div class="panel-body">
			<li>
				<?php echo $this->Html->link(
					__('Users'),
					array('controller' => 'users', 'action' => 'index')
				);?>
			</li>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
	        <h3 class="panel-title"><?php echo __('Create User');?></h3>
		</div>
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<?php
			$options = array(
			    'label' => __('Create User'),
			    'class' => 'btn btn-default');
			echo $this->Form->create('User', array(
			'class' => 'navbar-form navbar-left',
			'role' => 'user',
			'inputDefaults' => array(
			    'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			    'div' => array('class' => 'form-group'),
			    'class' => array('form-control'),
			    'label' => array('class' => 'navbar-text'),
			    'between' => '<div class="form-group">',
			    'after' => '</div>',
			    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
			)));
			echo $this->Form->input('username');
			echo $this->Form->input('password');
			echo $this->Form->end($options);
		?>
		</div>
	</nav>
</div>