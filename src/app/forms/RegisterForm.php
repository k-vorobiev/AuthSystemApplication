<?php
namespace app\forms;

use std, gui, framework, app;
use php\gui\framework\AbstractForm;

class RegisterForm extends AbstractForm
{

    /**
     * @event authBtn.action 
     */
    function doAuthBtnAction(UXEvent $e = null)
    {    
        $login = str::trim($this->regLogin->text);
        $email = str::trim($this->regEmail->text);
        $password = $this->regPassword->text;
        $repeatPassword = $this->regRepeatPassword->text;
        
        if ($password !== $repeatPassword) {
            UXDialog::show('Пароли должны совпадать', 'ERROR');
            return;
        }
        
        if (str::length($password) < 6) {
            UXDialog::show('Минимальная длина пароля 6 символов', 'ERROR');
            return;
        }
        
        if ($this->getUser($login)) {
            UXDialog::show('Данный логин уже занят', 'ERROR');
        } elseif ($this->getUserByEmail($email)) {
            UXDialog::show('Данный e-mail уже занят', 'ERROR');
        } else {
            $success = $this->register($login, $email, $password);
            
            if ($success) {
                $this->hide();
                $this->form('AuthForm')->authLogin->text = $login;
                alert('Вы успешно зарегистрировались');
            } else {
                UXDialog::show('Ошибка', 'ERROR');
            }
        }
    }
}
