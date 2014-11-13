<h1>Add Categories</h1>
<?php
echo $this->Form->create('Category');
echo $this->Form->input('category_name');
echo $this->Form->end('Save Category');
echo $this->Html->link('Go back', array('controller' => 'posts', 'action' => 'index'));
?>