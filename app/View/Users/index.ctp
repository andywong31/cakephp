
<?php if (isset($role) && $role == 'admin') : ?>
<?php echo $this->Html->link('Logout', array('controller' => 'Users', 'action' => 'logout')); ?>
<?php echo ' | ' . $this->Html->link('View posts', array('controller' => 'Posts')); ?>
<?php echo ' | ' . $this->Html->link('Go back', array('controller' => 'posts', 'action' => 'index')); ?>
<h1>List of users</h1>

<?php echo $this->Html->link('Add user', array('controller' => 'users', 'action' => 'add')); ?>
<table>
    <tr>        
        <th>Username</th>
        <th>Action</th>
        <th>Created</th>
    </tr>

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['username']; ?></td>        
        <td>
            <?php
                if ($user['User']['id'] != $id) {
                    echo $this->Form->postLink(
                        'Delete',
                        array('action' => 'delete', $user['User']['id']),
                        array('confirm' => 'Are you sure?')
                    );
                }                
            ?>
            <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', $user['User']['id'])
                );
            ?>
        </td>

        <td><?php echo $user['User']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>
<?php echo $this->Paginator->first(' First  ') . ' ' . $this->Paginator->numbers()  . ' ' . $this->Paginator->last(' Last '); ?>
<?php endif; ?>