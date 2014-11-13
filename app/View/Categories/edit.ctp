<h1>Edit Category</h1>
<?php
echo $this->Form->create('Category');
echo $this->Form->input('category_name');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Category');
echo $this->Html->link('Go back', array('controller' => 'categories', 'action' => 'index'));
?>
