<h1>Add Post</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('category_id', array('options' => $categories));   
echo $this->Form->end('Save Post');
echo $this->Html->link('Go back', array('controller' => 'posts', 'action' => 'index'));
?>