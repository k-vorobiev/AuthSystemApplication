<?php
namespace app\modules;

use std, gui, framework, app;

class UserModule extends AbstractModule
{
    protected $user = null;
    
    public function getLoggedUser() 
    {
        return $this->user;
    }
    
    public function getUsers()
    {
        return $this->users->toArray();
    }

    public function getUser($login)
    {
        return $this->users->section($login);
    }

    public function getUserByEmail($email)
    {
        foreach ($this->users->sections() as $login) {
            $user = $this->users->section($login);
            
            if (str::equalsIgnoreCase($email, $user['email'])) {
                return $user;
            }
        }

        return null;
    }
    
    public function getUserByEmailOrLogin($input)
    {
        foreach ($this->users->sections() as $login) {
            $user = $this->users->section($login);
            
            if (str::equalsIgnoreCase($input, $user['email'])) {
                return $user;
            }
            
            if (str::equalsIgnoreCase($input, $user['login'])) {
                return $user;
            }
        }

        return null;
    }

    public function logout()
    {
        $this->user = null;
    }

    public function register($login, $email, $password)
    {
        if (!$login || !$email || !$password) {
            return false;
        }
        
        if ($this->getUser($login)) {
            return false;
        } elseif ($this->getUserByEmail($email)) {
            return false;
        } else {
            $this->users->put([
                    'login' => $login,
                    'email' => $email, 
                    'passwordHash' => sha1($password)
            ], $login);
            return true;
        }
    }

    public function auth($login, $password)
    {
        $userData = $this->getUser($login);

        if ($userData) {
            $passwordHash = $userData['passwordHash'];

            if (sha1($password) == $passwordHash) {
                $this->user = $userData;
                
                return true;
            }
        }

        return false;
    }
}
