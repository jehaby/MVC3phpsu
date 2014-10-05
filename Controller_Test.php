<?php


class Controller_Test extends Controller_Base {
    function showAction($url = null)
    {
        if(!$this->currentUser)
        {
            $this->redirect('/test/auth');
        }
        $rgPages=$this->dbInstance->select('some_table', array(
            'id',
            'name'
        ));
        if(!$rgPages)
        {
            $rgPages=array();
        }
        $this->view->rgPages=$rgPages;
        $this->view->render('showview');
    }

    function updateAction()
    {
        $id=$this->getParam('id');
        $rgFields=array(
            'name'         => $this->getParam('name')
        );
        if(!$this->currentUser)
        {
            $this->redirect('/test/auth');
        }
        if(!$id)
        {
            $this->redirect('/test/show');
        }
        $this->dbInstance->update('some_table', $rgFields, array('id'=>$id));
        $this->redirect('/test/show');
    }

    function addAction()
    {
        if(!$this->currentUser)
        {
            $this->redirect('/test/auth');
        }
        $rgFields=array(
            'name'         => $this->getParam('name')
        );
        $this->dbInstance->insert('some_table', $rgFields);
        $this->redirect('/test/show');
    }

    function deleteAction()
    {
        if(!$this->currentUser)
        {
            $this->redirect('/test/auth');
        }
        $id = $this->getParam('id');
        if(!$id)
        {
            $this->redirect('/test/show');
        }
        $this->dbInstance->delete('some_table', array('id'=>$id));
        $this->redirect('/test/show');
    }

    function authAction()
    {
        $this->view->render('auth');
    }

    function loginAction()
    {
        /*
        Here we log in user. If success, redirect to /test/show
        If fails, redirect to /test/auth
        */

    }

    function logoutAction()
    {
        $this->logoutUser();
        $this->redirect('/test/auth');
    }
} 