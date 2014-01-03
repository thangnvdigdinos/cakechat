<?php foreach ($messages as $message): ?>
<tbody>
	<tr>
		<td><?php echo $message['id']; ?></td>
		<td>
			<?php var_dump($message); ?>
		</td>
	</tr>
</tbody>
<?php endforeach; ?>
<?php unset($message); ?>