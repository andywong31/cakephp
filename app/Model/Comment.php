<?php
class Comment extends AppModel {
	// public $hasOne = array(
	// 	'User' => array(
	// 		'className' => 'User'
	// 	)
	// );

	public $belongsTo = array(
		'User' => array(
			'className' => 'User'
		)		
	);
}