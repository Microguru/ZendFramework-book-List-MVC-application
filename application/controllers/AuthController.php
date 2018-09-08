<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */


    }

    public function indexAction()
    {

    }

    public function logoutAction()
    {

        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect('/index/index');
    }

    public function loginAction()
    {
        // action body

        if(Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('book/index');
        }
        $request =$this->getRequest();
        $form=new Application_Form_Login();
        if($request->isPost()){
            if($form->isValid($this->_request->getPost()))
            {
                $authAdapter=$this->getAuthAdapter();
                $username =htmlspecialchars($form->getValue('username'));
                $password = htmlspecialchars($form->getValue('password'));
                $authAdapter->setIdentity($username)->setCredential($password);
                $auth= Zend_Auth::getInstance();
                $result=$auth->authenticate($authAdapter);
                if($result->isValid())
                {
                    $identity=$authAdapter->getResultRowObject();
                    $authStorage=$auth->getStorage();
                    $authStorage->write($identity);
                    $this->_redirect('book/index');
                }
                else
                {
                    $this->view->errorMessage="Username or Password is wrong";
                }
            }
        }
        $form=new Application_Form_Login();
        $this->view->form = $form;
    }

    private function getAuthAdapter()
    {
        $authAdapter =new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('user')
                    ->setIdentityColumn('username')
            ->setCredentialColumn('password');
        return $authAdapter;

    }

}



