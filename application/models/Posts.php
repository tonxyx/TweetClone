<?php

class Application_Model_Posts
{
    public function saveNewPost($postData)
    {
        $PostsModel = new Application_Model_DbTable_Posts();

        $post = $PostsModel->createRow();

        $post->postText = $postData;

        $auth = Zend_Auth::getInstance();

        try {
            if (!$auth->hasIdentity()) {
                throw new Exception("You are not logged in!");
                $this->redirect('/auth/login');
            }
            else
            {
                $info = $auth->getIdentity();
                $post->userId = $info->id;
            }
        }
        catch (Zend_Exception $e) {
            throw $e;
        }

        return $post->save();
    }

    public function getPosts()
    {
        $PostsModel = new Application_Model_DbTable_Posts();

        $post = $PostsModel->fetchAll(
            $PostsModel->select()->setIntegrityCheck(false)->from('posts')->joinLeft('users', 'users.id = posts.userId', array('email'))->order('postTime desc')
        );

        return $post;
    }

    public function deletePostById($postId)
    {
        $PostsModel = new Application_Model_DbTable_Posts();

        $post = $PostsModel->fetchRow('id = '. $postId);

        $post->delete();
    }
}