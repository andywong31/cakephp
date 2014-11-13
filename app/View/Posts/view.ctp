<h1><?php echo h($post['Post']['title']); ?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>

<?php 
echo $this->Form->create('Comment');
echo $this->Form->input('comment', array('type' => 'textarea'));
echo $this->Form->hidden('comment_date', array('value' => date('Y-m-d g:i:s')));
echo $this->Form->submit();
?>

<?php echo $this->Html->link('Go back', array('controller' => 'posts', 'action' => 'index')); ?>

<h2>Comment</h2>
<table>
<?php
echo $this->html->tableHeaders(array('userid','comment', 'comment date'));

foreach ($post['Comment'] as $comment) {
	echo $this->html->tableCells(array($comment['User']['username'], $comment['comment'], $comment['comment_date']));
}
?>
</table>