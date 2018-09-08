<?php

class IndexController extends Zend_Controller_Action
{

    public function init ()
    {
        /* Initialize action controller here */
    }

    public function indexAction ()
    {

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->username;

            $this->view->bt = $username;
        }
        $booksTl = new Application_Model_DbTable_Books();
        $this->view->books = $booksTl->fetchAll();

    }


}

