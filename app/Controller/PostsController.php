<?php
class PostsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session', 'Paginator');
	// public $uses = array('Category', 'Post');

	public function beforeFilter() {
        parent::beforeFilter();

        if ($this->Auth->user('role') == 'admin') {
        	$this->Auth->allow('index', 'add', 'edit', 'delete', 'logout');	
        }
        elseif ($this->Auth->user('role') == 'user') {
        	$this->Auth->allow('add', 'logout');	
        }
    }

	public function index() {
		$categories = $this->Post->Category->find('list', array('fields' => array('id', 'category_name')));
		$users = $this->Post->User->find('list', array('fields' => array('id', 'username')));		
		$this->set('categories', $categories);
		$this->set('users', $users);
		$this->set('role', $this->Auth->user('role'));
		$this->set('id', $this->Auth->user('id'));
		$this->Paginator->settings = $this->paginate;
		
		if ($this->request->is('get')) {			
			if (empty($this->request->query)) {						
				$data = $this->Paginator->paginate();				
			}			
			else {						
				$query = $this->request->query['q'];				
				$status = $this->request->query['status'];
				
				if ($status == 'active') {
					$result = array('Post.is_delete' => 0);
				}
				elseif ($status == 'inactive') {
					$result = array('Post.is_delete' => 1);
				}
				else {
					$result = array('Post.is_delete IN ' => array(1, 0));
				}
				$category_id = $this->request->query['category_id'];				
				$user_id = $this->request->query['user_id'];				

				$result['category_id'] = $category_id;				
				$result['user_id'] = $user_id;				
				$data = $this->Paginator->paginate('Post', array(
					'OR' => array(
						'Post.title LIKE' => '%' . $query .'%',
						'Post.body LIKE' => '%' . $query . '%'
						),
					'AND' => $result
					)
				);
			}
			$this->set('posts', $data);
		}		
		else {			
			$query = $this->request->data['Post']['status'];
			if ($query == 'active') {
				$query = array('Post.is_delete' => array(0));
			}
			elseif ($query == 'inactive') {
				$query = array('Post.is_delete' => array(1));
			}
			else {
				$query = array('Post.is_delete IN ' => array(1, 0));
			}
			$data = $this->Paginator->paginate('Post', $query);					
			$this->set('posts', $data);
		}
	}	 

	public $paginate = array(		
			'fields' => array('Post.id', 'Post.title', 'Post.created', 'user_id', 'is_delete', 'User.username', 'Category.category_name'),
	        'limit' => 4	        
    );

	public function isAuthorized($user) {		
	    // All registered users can add posts
	    if ($this->action === 'add') {
	        return true;
	    }

	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('edit', 'delete'))) {
	        $postId = (int) $this->request->params['pass'][0];

	        if ($this->Post->isOwnedBy($postId, $user['id'])) {
	            return true;
	        }
	    }
	    return parent::isAuthorized($user);
	}

	public function view($id = null) {		
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->Post->recursive = 2;
		$post = $this->Post->findById($id);		

        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }        
        
        if ($this->request->is('post')) {        	        	        	
        	$this->request->data['Comment']['post_id'] = $id;        	
        	$this->request->data['Comment']['user_id'] = $this->Auth->user('id');        	
        	$this->Post->Comment->save($this->request->data); 
        	$this->Session->setFlash(__('Comment has been saved.'));
        	return $this->redirect(array('action' => 'view', $id));       	
        }                
        $this->set('post', $post);
	}

	public function add() {			
		$categories = $this->Post->Category->find('list', array('fields' => array('id', 'category_name')));
		$this->set('categories', $categories);
		$this->set('role', $this->Auth->user('role'));

	    if ($this->request->is('post')) {	        	 
	        $this->request->data['Post']['user_id'] = $this->Auth->user('id');

	        if ($this->Post->save($this->request->data)) {
	            $this->Session->setFlash(__('Your post has been saved.'));
	            return $this->redirect(array('action' => 'index'));
	        }
	        $this->Session->setFlash(__('Unable to add your post.'));
	    }
	}

	public function edit($id = null) {	
		$categories = $this->Post->Category->find('list', array('fields' => array('id', 'category_name')));	
		$this->set('categories', $categories);
		$this->set('role', $this->Auth->user('role'));

		if (!$id) {
	        throw new NotFoundException(__('Invalid post'));
	    }

	    $post = $this->Post->findById($id);
	    
	    if (!$post) {
	        throw new NotFoundException(__('Invalid post'));
	    }
	    
	    if ($this->request->is(array('post', 'put'))) {			    	    
	        $this->Post->id = $id;
	        if ($this->Post->save($this->request->data)) {
	            $this->Session->setFlash(__('Your post has been updated.'));
	            return $this->redirect(array('action' => 'index'));
	        }
	        $this->Session->setFlash(__('Unable to update your post.'));
	    }

	    if (!$this->request->data) {
	        $this->request->data = $post;
	    }
	}

	public function delete($id) {
		if ($this->request->is(array('post', 'put'))) {			
			$this->request->data['Post']['id'] = (int) $id;
			$this->request->data['Post']['is_delete'] = 1;
			$this->Post->save($this->request->data);			
	    }	    
        $this->Session->setFlash(
            __('The post with id: %s has been deleted.', h($id))
        );
        return $this->redirect(array('action' => 'index'));	    
	}
}