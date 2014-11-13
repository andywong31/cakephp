<h1>List of categories</h1>

<?php 
echo $this->Html->link('Add category', array('controller' => 'categories', 'action' => 'add')); 
echo ' | ' . $this->Html->link('Go back', array('controller' => 'posts', 'action' => 'index'));
?>
<table>
    <tr>        
        <th>Category name</th>        
        <th>Created</th>
        <th>Action</th>
    </tr>

    <?php foreach ($categories as $category): ?>
    <tr>
        <td><?php echo $category['Category']['category_name']; ?></td>        
        <td><?php echo $category['Category']['date_created']; ?></td>
        <td>
            <?php                
            echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $category['Category']['id']),
                array('confirm' => 'Are you sure?')
            );                             
            ?>
            <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', $category['Category']['id'])
                );
            ?>
        </td>

        
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>