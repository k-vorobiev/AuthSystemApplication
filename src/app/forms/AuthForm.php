<?php
namespace app\forms;

use std, gui, framework, app;


class AuthForm extends AbstractForm
{


    /**
     * @event authBtn.action 
     */
    function doAuthBtnAction(UXEvent $e = null)
    {    
        $login = $this->authLogin->text;
        $password = $this->authPassword->text;
        
        if (!$this->getUser($login)) {
            UXDialog::show('Пользователь с таким логином не найден', 'ERROR');
            return;
        }
        
        if (str::length($password) < 6) {
            UXDialog::show('Минимальная длина пароля 6 символов', 'ERROR');
            return;
        }
        
        $success = $this->auth($login, $password);
        
        if ($success) {
            $this->password = '';
            $this->loadForm('MainForm');
        } else {
            UXDialog::showAndWait('Вы ввели неверный логин или пароль', 'ERROR');
        }
    }

    /**
     * @event authRememberLink.action 
     */
    function doAuthRememberLinkAction(UXEvent $e = null)
    {    
        
    }

    /**
     * @event authRegisterLink.action 
     */
    function doAuthRegisterLinkAction(UXEvent $e = null)
    {    
        
    }

}
