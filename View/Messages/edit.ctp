<!-- File: /app/View/Messages/edit.ctp -->
<h1>Edit Message</h1>
<?php
echo $this->Form->create('Message');
echo $this->Form->input('content');
echo $this->Form->input('userid');
echo $this->Form->input('created');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Message');
?>