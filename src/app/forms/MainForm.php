<?php
namespace app\forms;

use std, gui, framework, app;


class MainForm extends AbstractForm
{
    /**
     * @event showing 
     **/
    function doConstruct(UXEvent $event = null)
    {
        $user = $this->getLoggedUser();
        $this->loginLabel->text = $user['login'];
    }

    /**
     * @event logoutBtn.action 
     */
    function doLogoutBtnAction(UXEvent $e = null)
    {    
        $this->logout();
        $this->loadForm('AuthForm');
    }
    
}
