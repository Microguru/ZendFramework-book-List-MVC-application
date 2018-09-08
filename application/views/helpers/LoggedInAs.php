<?php
/**
 * Created by PhpStorm.
 * User: manish
 * Date: 15/8/18
 * Time: 9:16 PM
 */

class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{
    public function loggedInAs ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->username;
            $logoutUrl = $this->view->url(array('controller' => 'auth',
                'action' => 'logout'), null, true);
            return 'Welcome ' . $username . '. Logout';
        }
    }
}