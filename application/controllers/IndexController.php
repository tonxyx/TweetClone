<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $form = new Application_Form_NewPost();
        $posts = new Application_Model_Posts();

        $formData = $this->getRequest()->getParams();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($formData)) {
                $post = $this->getParam('postText');
                $posts->saveNewPost($post);
                $form->reset();
            } else {
                // email is invalid; print the reasons
                echo "Error!";

            }
        }

        $this->view->form = $form;

        $postParts = $posts->getPosts();

        $paginator = Zend_Paginator::factory($postParts);
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($this->getParam('page', 1));

        $this->view->paginator = $paginator;
    }

    public function deleteAction()
    {
       $posts = new Application_Model_Posts();

       $posts->deletePostById($this->getParam('id'));

       $this->redirect('index');
    }
}