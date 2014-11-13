<?php
class CategoriesController extends AppController {
	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'add', 'edit', 'delete');	
    }

	public function index() {				
		$this->set('categories', $this->Category->find('all'));
	}

	public function add() {
		if ($this->request->is('post')) {			
			$this->Category->save($this->request->data);
			$this->Session->setFlash(__('Category has been added.'));
        	return $this->redirect(array('action' => 'index'));       	
		}
	}

	public function edit($id = null) {		
		if (!$id) {
	        throw new NotFoundException(__('Invalid category'));  
	    }

	    $category = $this->Category->findById($id);
	    
	    if (!$category) {	    	
	        throw new NotFoundException(__('Invalid category'));
	    }
	    
	    if ($this->request->is(array('post', 'put'))) {			    	
	        $this->Category->id = $id;

	        if ($this->Category->save($this->request->data)) {
	            $this->Session->setFlash(__('Your category has been updated.'));
	            return $this->redirect(array('action' => 'index'));
	        }
	        $this->Session->setFlash(__('Unable to update your category.'));
	    }

	    if (!$this->request->data) {
	        $this->request->data = $category;
	    }
	}

	public function delete($id = null) {
        // $this->request->onlyAllow('post');

        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('Category deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
}