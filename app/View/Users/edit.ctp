<?php if (isset($role) && $role == 'admin') : ?>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'author' => 'Author')
        ));
    ?>
    </fieldset>
<?php
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end(__('Submit')); ?>
</div>
<?php endif; ?>