<?php 
if (isset($role)) {
    echo $this->Html->link('Logout', array('controller' => 'Users', 'action' => 'logout'));     
}
?>
<?php 
if ($role == 'admin') {
    echo ' | ' . $this->Html->link('View users', array('controller' => 'Users'));
} 
echo ' | ' . $this->Html->link('View category', array('controller' => 'categories'));
?>

<h1>Blog posts</h1>

<?php 
    echo $this->Form->create("Post",array('action' => 'index', 'type' => 'get'));
    echo $this->Form->input("q", array('label' => 'Search for', 'value' => @$this->params->query['q']));         
    echo $this->Form->input('status', array('options' => array('all' => 'All', 'active' => 'Active', 'inactive' => 'Inactive'),'selected' =>@$this->params->query['status']));  
    echo $this->Form->input('category_id', array('options' => $categories, 'selected' =>@$this->params->query['category_id']));   
    echo $this->Form->input('user_id', array('options' => $users, 'selected' =>@$this->params->query['user_id']));   
    echo $this->Form->end("Search");
?> 

<?php 
if (isset($role)) {
    echo $this->Html->link('Add post', array('controller' => 'posts', 'action' => 'add'));    
}
?>
<table>
    <tr>
        <th>User</th>
        <th>Title</th>
        <th>Category</th>
        <th>Action</th>
        <th>Created</th>
        <th>Status</th>
    </tr>

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['User']['username']; ?></td>        
        <td>
            <?php echo $this->Html->link($post['Post']['title'],
array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?>
        </td>
        <td><?php echo $post['Category']['category_name']; ?></td>
        <td>
        <?php 
        if ($role == 'admin' || $post['Post']['user_id'] == $id) {
            echo $this->Form->postLink('Delete', array('action' => 'delete', $post['Post']['id']),array('confirm' => 'Are you sure?'));                        
               echo ' ' . $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id']));
        }
        ?>        
        </td>

        <td><?php echo $post['Post']['created']; ?></td>
        <td><?php echo ($post['Post']['is_delete'] == 1) ? 'Inactive' : 'Active'; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>
<?php echo $this->Paginator->first(' First  ') . ' ' . $this->Paginator->numbers()  . ' ' . $this->Paginator->last(' Last '); ?>