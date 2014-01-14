<?php

class Application_Model_Posts
{
    public function saveNewPost($postData)
    {
        $PostsModel = new Application_Model_DbTable_Posts();

        $post = $PostsModel->createRow();

        $post->postText = $postData;

        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $this->info = $auth->getIdentity();
        }

        $post->userId = $this->info->id;

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