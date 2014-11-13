<?php
class Post extends AppModel {	
	public $belongsTo = array(
        'User' => array(
            'className' => 'User'
        ),
        'Category' => array(
        	'className' => 'Category'
        )
    );

	public $hasMany = array(
        'Comment' => array(
        	'className' => 'Comment'        	
        ),
        'Category' => array(
        	'className' => 'Category'
        )
    );

	public $validate = array(
		'title' => array(
				'rule' => 'notEmpty'
			),
		'body' => array(
				'rule' => 'notEmpty'
			)
	);

    public function isOwnedBy($post, $user) {        
        return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
    }
}