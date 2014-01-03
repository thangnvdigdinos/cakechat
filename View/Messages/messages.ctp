<?php foreach ($messages as $message): ?>
<tbody>
	<tr>
		<td><?php echo $message['Message']['id']; ?></td>
		<td>
			<?php 
				if($message['Message']['status'] ==1) 
				{
					echo "<p style='color:red'>".$message['Message']['content']; 
					echo " (Has removed)</p>"; 
				}
				else{
					echo $message['Message']['content'];
				}
			?>
		</td>
		<td>
		<?php
			if($message['Message']['status'] != 1){
				echo $this->Form->postLink(
					'Delete',
					array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'], $message['Thread']['id']),
					array('confirm' => __('are you sure to delete?'))
				);
				echo "/";
				echo $this->Html->link(
					'Edit',
					array('controller' => 'threads', 'action' => 'view', $message['Thread']['id'], $message['Message']['id'])
				);
			}
		?>
		</td>
		<td><?php echo $message['User']['username']; ?></td>
		<td><?php echo $message['Message']['created']; ?></td>
		<td><?php echo $message['Message']['updated']; ?></td>
	</tr>
</tbody>
<?php endforeach; ?>
<?php unset($message); ?>