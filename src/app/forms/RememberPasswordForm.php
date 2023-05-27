<?php
namespace app\forms;

use std, gui, framework, app;


class RememberPasswordForm extends AbstractForm
{

    /**
     * @event rememberBtn.action 
     */
    function doRememberBtnAction(UXEvent $e = null)
    {    
        $input = $this->rememberInput->text;
        $user = $this->getUserByEmailOrLogin($input);
        
        if (!$user) {
            UXDialog::show('Пользователь не найден', 'ERROR');
            return;
        }
        
        $email = $user['email'];
        UXDialog::show('Письмо отправлено на ' . $email);
    }

}
