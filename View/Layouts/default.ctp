<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'CakePHP: Chat system');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
		
		echo $this->Html->css('bootstrap');

		echo $this->Html->css('bootstrap.min');

		echo $this->Html->css('bootstrap-theme');

		echo $this->Html->css('bootstrap-theme.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		
		echo $this->Html->script('jquery-1.8.3.min');
		echo $this->Html->script('bootstrap');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('chatsystem');
	?>
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>
			<?php if(AuthComponent::user('username')): ?>
			    Welcome <?php echo AuthComponent::user('username'); ?>
			<?php else: ?>
			    Welcome guest, please <?php
					echo $this->Html->link(
						'login',
						array('controller' => 'users', 'action' => 'login', null)
					);
				?>
			<?php endif; ?>
			</h1>
			<?php
				if(AuthComponent::user('username')){
					echo $this->Html->link(
					'logout',
					array('controller' => 'users', 'action' => 'logout', null)
				);
				}
			?>
		</div>
		<div class="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
